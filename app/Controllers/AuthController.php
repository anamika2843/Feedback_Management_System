<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class AuthController extends BaseController
{
    protected $auth;

    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var Session
     */
    protected $session;

    public function __construct()
    {
        helper('general');
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');

        $this->config       = config('Auth');
        $this->auth         = service('authentication');
        $this->custom_model = model('App\Models\Custom_model');
        $this->parser       = \Config\Services::parser();
    }

    //--------------------------------------------------------------------
    // Login/out
    //--------------------------------------------------------------------

    /**
     * Displays the login form, or redirects
     * the user to their destination/home if
     * they are already logged in.
     */
    public function login()
    {
        // No need to show a login form if the user
        // is already logged in.
        if ($this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/admin/home');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        // Set a return URL if none is specified
        $_SESSION['redirect_url'] = site_url('/admin/home'); //session('redirect_url') ?? previous_url() ?? site_url('/admin/home');

        return $this->_render($this->config->views['login'], ['config' => $this->config]);
    }

    /**
     * Attempts to verify the user's credentials
     * through a POST request.
     */
    public function attemptLogin()
    {
        $rules = [
            'login'	   => 'required',
            'password' => 'required',
        ];
        if ($this->config->validFields == ['email']) {
            $rules['login'] .= '|valid_email';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ('yes' == get_option('enable_while_login') && !validate_re_captcha('enable_while_login', $this->request)) {
            set_alert('danger', app_lang('re-captcha'), app_lang('human_verification_failed'));

            return redirect()->back()->withInput();
        }

        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');

        // Determine credential type
        $type = filter_var($login, \FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Try to log them in...
        if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
            set_alert('danger', app_lang('error'), app_lang('badAttempt'));

            return redirect()->back()->withInput()->with('error', $this->auth->error() ?? app_lang('badAttempt'));
        }

        // Is the user being forced to reset their password?
        if (true === $this->auth->user()->force_pass_reset) {
            return redirect()->to(route_to('reset-password').'?token='.$this->auth->user()->reset_hash)->withCookies();
        }

        $redirectURL = site_url('/admin/home'); //session('redirect_url') ?? site_url('/admin/home');
        unset($_SESSION['redirect_url']);

        set_alert('success', app_lang('success'), app_lang('loginSuccess'));

        return redirect()->to($redirectURL)->withCookies()->with('message', app_lang('loginSuccess'));
    }

    /**
     * Log the user out.
     */
    public function logout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to(site_url('/'));
    }

    //--------------------------------------------------------------------
    // Forgot Password
    //--------------------------------------------------------------------

    /**
     * Displays the forgot password form.
     */
    public function forgotPassword()
    {
        if (null === $this->config->activeResetter) {
            set_alert('danger', app_lang('error'), app_lang('forgotDisabled'));

            return redirect()->route('login')->with('error', app_lang('forgotDisabled'));
        }

        return $this->_render($this->config->views['forgot'], ['config' => $this->config]);
    }

    /**
     * Attempts to find a user account with that password
     * and send password reset instructions to them.
     */
    public function attemptForgot()
    {
        if (null === $this->config->activeResetter) {
            set_alert('danger', app_lang('error'), app_lang('forgotDisabled'));

            return redirect()->route('login')->with('error', app_lang('forgotDisabled'));
        }

        $users = model(UserModel::class);

        $user = $users->where('email', $this->request->getPost('email'))->first();

        if (null === $user) {
            set_alert('danger', app_lang('error'), app_lang('forgotNoUser'));

            return redirect()->back()->with('error', app_lang('forgotNoUser'));
        }

        if ('yes' == get_option('enable_while_forgot_password') && !validate_re_captcha('enable_while_forgot_password', $this->request)) {
            set_alert('danger', app_lang('re-captcha'), app_lang('human_verification_failed'));

            return redirect()->back()->withInput();
        }

        // Save the reset hash /
        $user->generateResetHash();
        $users->save($user);

        $resetter = service('resetter');

        $email_template                          = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'user-reset-password']);
        if($email_template)
        {
            if($email_template->active)
            {
                $parser_data = parse_merge_fields('user-reset-password', ["reset_password" => $user]);

                $mail_body = get_option('email_header');
                $mail_body .= $email_template->message;
                $mail_body .= get_option('email_footer');
                $message = $this->parser->setData($parser_data)->renderString($mail_body);
                $sent    = send_app_mail($user->email, $email_template->subject, $message);
                if (!$sent) {
                    set_alert('danger', app_lang('error'), app_lang('unknownError'));

                    return redirect()->back()->withInput()->with('error', $resetter->error() ?? app_lang('unknownError'));
                } 
                set_alert('success', app_lang('success'), app_lang('forgotEmailSent'));
            }
        }
        set_alert('danger', app_lang('error'), app_lang('unknownError'));

        return redirect()->route('reset-password')->with('message', app_lang('forgotEmailSent'));
    }

    /**
     * Displays the Reset Password form.
     */
    public function resetPassword()
    {
        if (null === $this->config->activeResetter) {
            set_alert('danger', app_lang('error'), app_lang('forgotDisabled'));

            return redirect()->route('login')->with('error', app_lang('forgotDisabled'));
        }

        $token = $this->request->getGet('token');

        return $this->_render($this->config->views['reset'], [
            'config' => $this->config,
            'token'  => $token,
        ]);
    }

    /**
     * Verifies the code with the email and saves the new password,
     * if they all pass validation.
     *
     * @return mixed
     */
    public function attemptReset()
    {
        if (null === $this->config->activeResetter) {
            set_alert('danger', app_lang('error'), app_lang('forgotDisabled'));

            return redirect()->route('login')->with('error', app_lang('forgotDisabled'));
        }

        $users = model(UserModel::class);

        // First things first - log the reset attempt.
        $users->logResetAttempt(
            $this->request->getPost('email'),
            $this->request->getPost('token'),
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent()
        );

        $rules = [
            'token'		      => 'required',
            'email'		      => 'required|valid_email',
            'password'	    => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];
        $error=[
            'pass_confirm' => ['required'=> app_lang('confirm_password_required'), 'matches'=> app_lang('confirm_password_not_match')],
        ];

        if (!$this->validate($rules, $error)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $users->where('email', $this->request->getPost('email'))
        ->where('reset_hash', $this->request->getPost('token'))
        ->first();
        if ('yes' == get_option('enable_while_reset_password') && !validate_re_captcha('enable_while_reset_password', $this->request)) {
            set_alert('danger', app_lang('re-captcha'), app_lang('human_verification_failed'));

            return redirect()->back()->withInput();
        }

        if (null === $user) {
            set_alert('danger', app_lang('error'), app_lang('forgotNoUser'));

            return redirect()->back()->with('error', app_lang('forgotNoUser'));
        }

        // Reset token still valid?
        if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
            return redirect()->back()->withInput()->with('error', app_lang('resetTokenExpired'));
        }

        // Success! Save the new password, and cleanup the reset hash.
        $user->password 		      = $this->request->getPost('password');
        $user->reset_hash 		    = null;
        $user->reset_at 		      = date('Y-m-d H:i:s');
        $user->reset_expires    = null;
        $user->force_pass_reset = false;
        $users->save($user);

        set_alert('success', app_lang('success'), app_lang('resetSuccess'));

        return redirect()->route('login')->with('message', app_lang('resetSuccess'));
    }

    /**
     * Activate account.
     *
     * @return mixed
     */
    public function activateAccount()
    {
        $users = model(UserModel::class);

        // First things first - log the activation attempt.
        $users->logActivationAttempt(
            $this->request->getGet('token'),
            $this->request->getIPAddress(),
            (string) $this->request->getUserAgent()
        );

        $throttler = service('throttler');

        if (false === $throttler->check(md5($this->request->getIPAddress()), 2, MINUTE)) {
            set_alert('danger', app_lang('error'), app_lang('tooManyRequests'));

            return service('response')->setStatusCode(429)->setBody(app_lang('tooManyRequests', [$throttler->getTokentime()]));
        }

        $user = $users->where('activate_hash', $this->request->getGet('token'))
        ->where('active', 0)
        ->first();

        if (null === $user) {
            set_alert('danger', app_lang('error'), app_lang('activationNoUser'));

            return redirect()->route('login')->with('error', app_lang('activationNoUser'));
        }

        $user->activate();

        $users->save($user);

        set_alert('success', app_lang('success'), app_lang('registerSuccess'));

        return redirect()->route('login')->with('message', app_lang('registerSuccess'));
    }

    /**
     * Resend activation account.
     *
     * @return mixed
     */
    public function resendActivateAccount()
    {
        if (null === $this->config->requireActivation) {
            return redirect()->route('login');
        }

        $throttler = service('throttler');

        if (false === $throttler->check(md5($this->request->getIPAddress()), 2, MINUTE)) {
            return service('response')->setStatusCode(429)->setBody(app_lang('tooManyRequests', [$throttler->getTokentime()]));
        }

        $login = urldecode($this->request->getGet('login'));
        $type  = filter_var($login, \FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $users = model(UserModel::class);

        $user = $users->where($type, $login)
        ->where('active', 0)
        ->first();

        if (null === $user) {
            set_alert('danger', app_lang('error'), app_lang('activationNoUser'));

            return redirect()->route('login')->with('error', app_lang('activationNoUser'));
        }

        $activator = service('activator');
        $sent      = $activator->send($user);

        if (!$sent) {
            set_alert('danger', app_lang('error'), app_lang('unknownError'));

            return redirect()->back()->withInput()->with('error', $activator->error() ?? app_lang('unknownError'));
        }

        // Success!
        set_alert('success', app_lang('success'), app_lang('activationSuccess'));

        return redirect()->route('login')->with('message', app_lang('activationSuccess'));
    }

    protected function _render(string $view, array $data = [])
    {
        return view($view, $data);
    }
}
