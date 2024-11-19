<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Entities\User;

class MemberController extends App_Controller
{
    protected $config;

    public function __construct()
    {
        parent::__construct();
        $this->data['menu_item']     ='members';
        $this->data['title']         = 'Members';
        $this->data['breadcrumb']    =['/admin/members'=>'Members'];
        $this->data['menu_collapse'] = true;
        $this->custom_model          = Model('App\Models\Custom_model');
        $this->config                = config('Auth');
        $this->group_model           = model(GroupModel::class);
        $this->authorize             = Services::authorization();
    }

    public function index()
    {
        $this->data['title'] = app_lang('members');

        return view('members/table', $this->data);
    }

    public function table()
    {
        $builder = $this->db->table('users')->select('id,username,email');

        return DataTable::of($builder)
        ->addNumbering('no')
        ->setSearchableColumns(['username', 'email'])
        ->add('action', function ($data) {
            return "<button type='button' aria-haspopup='true' data-bs-toggle='dropdown' aria-expanded='false' class='btn btn-link'>
            <i class='fa fa-ellipsis-h'></i></button>
            <div tabindex='-1' aria-hidden='true' class='dropdown-menu dropdown-menu-right' style='width:10%''>

            <ul class='nav flex-column'>
            <li class='nav-item'>
            <a href='".site_url('admin/members/show/'.$data->id)."' class='nav-link edit-users' data-id='".$data->id."' data-value='".json_encode($data, \ENT_QUOTES)."'>
            <i class='nav-link-icon lnr-book'></i>
            <span> ".app_lang('edit')."</span>
            </a>
            </li>
            <li class='nav-item'>
            ".form_open('admin/members/delete/'.$data->id).csrf_field()."
            <button type='submit' class='nav-link btn btn-link text-primary'>
            <i class='nav-link-icon lnr-trash'></i>
            <span>".app_lang('delete').'</span
            </button>
            '.form_close().'
            </li>
            </ul>
            </div>
            </div>';
        })->toJson(true);
    }

    public function delete($id)
    {
        if ($this->custom_model->deleteRow('users', ['id'=>$id])) {
            set_alert('success', app_lang('members'), app_lang('members_deleted_success'));

            return redirect()->to('admin/members');
        }
        set_alert('danger', app_lang('members'), app_lang('members_deleted_fail'));

        return redirect()->to('admin/members');
    }

    public function show()
    {
        $id = $this->request->uri->getSegment(4);
        if (is_numeric($id)) {
            $this->data['user']       = $this->custom_model->getSingleRow('users', ['id'=>$id]);
            $this->data['user_group'] = $this->group_model->getGroupsForUser($id);
        }
        $this->data['roles'] = $this->custom_model->getRows('auth_groups');

        return view('members/manage', $this->data);
    }

    public function store()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id          = $this->request->uri->getSegment(4);
        $users       = model(UserModel::class);
        // Validate basics first since some password rules rely on these fields
        $rules = [
            'username'     => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
            'email'        => 'required|valid_email|is_unique[users.email,id,{id}]',
            'role'         => 'required',
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];
        $error=[
            'pass_confirm' => ['required'=> app_lang('confirm_password_required'), 'matches'=> app_lang('confirm_password_not_match')],
        ];

        if (is_numeric($id)) {
            // Validate passwords since they can only be validated properly here
            if (!empty($this->request->getPost('password'))) {
                $rules = [
                    'password'     => 'required|strong_password',
                    'pass_confirm' => 'required|matches[password]',
                ];
                $error=[
                    'pass_confirm' => ['required'=> app_lang('confirm_password_required'), 'matches'=> app_lang('confirm_password_not_match')],
                ];

                if (!$this->validate($rules, $error)) {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
            } else {

                $rules = [
                    'username'     => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
                    'email'        => 'required|valid_email|is_unique[users.email,id,{id}]',
                    'role'         => 'required',
                ];
                if (!$this->validate($rules)) {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                $allowedPostFields = $this->config->validFields;
            }

            // Save the user
            $user = new User($this->request->getPost($allowedPostFields));

            //delete the previous group of user
            $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
            // Ensure default group gets assigned if set
            $this->authorize->addUserToGroup($id, $this->request->getPost('role'));

            $user->id = $id;
            if (!$users->save($user)) {
                set_alert('danger', app_lang('members'), app_lang('fail_to_member_updated'));

                return redirect()->back()->withInput()->with('errors', $users->errors());
            }

            set_alert('success', app_lang('members'), app_lang('member_updated'));

            return redirect()->to('admin/members');
        }

        if (!$this->validate($rules, $error)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate passwords since they can only be validated properly here
        $rules = [
                'password'     => 'required|strong_password',
                'pass_confirm' => 'required|matches[password]',
            ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user              = new User($this->request->getPost($allowedPostFields));

        $activation_hash = null === $this->config->requireActivation ? $user->activate() : $user->generateActivateHash();

        $id = $users->insert(new User([
                'email'        => $this->request->getPost('email'),
                'username'     => $this->request->getPost('username'),
                'password'     => $this->request->getPost('password'),
                'activate_hash'=> $activation_hash->activate_hash,
            ]));

        $this->authorize->addUserToGroup($id, $this->request->getPost('role'));

        if (null !== $this->config->requireActivation) {
            $activator                          = service('activator');
            $email_template                     = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'user-activation']);
            if($email_template)
            {
                if($email_template->active)
                {
                    $parser_data = parse_merge_fields('user-reset-password', ["user" => $user]);

                    $mail_body = get_option('email_header');
                    $mail_body .= $email_template->message;
                    $mail_body .= get_option('email_signature');
                    $mail_body .= get_option('email_footer');
                    $message = $this->parser->setData($parser_data)->renderString($mail_body);
                    $sent    = send_app_mail($user->email, $email_template->subject, $message);
                    //$sent = $activator->send($user);
                    if (!$sent) {
                        set_alert('danger', app_lang('members'), lang('Auth.errorSendingActivation', [$user->email]));

                        return redirect()->to('admin/members/show/'.$id);
                    }

                    set_alert('success', app_lang('members'), app_lang('Auth.activationSuccess'));
                }
            }
            set_alert('danger', app_lang('members'), lang('Auth.errorSendingActivation', [$user->email]));
            return redirect()->to('admin/members');
        }

        set_alert('success', app_lang('members'), app_lang('Auth.registerSuccess'));

        return redirect()->to('admin/members');
    }
}
