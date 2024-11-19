<?php 


/**
* [add_option to setttings in options table]
* @param string  $name     [key name]
* @param string  $value    [key value]
* @param integer $autoload [autoload or not default is autoload]
*/
function add_option($name, $value = '', $autoload = 1)
{
	$con = db_connect();	
	$db  = $con->table('options');
	if (!option_exists($name)) {        

		$newData = [
			'name'  => $name,
			'value' => $value,
		];

		if ($con->fieldExists('autoload','options')) {
			$newData['autoload'] = $autoload;
		}

		$db->insert($newData);        
		$insert_id = $con->insertID();

		if ($insert_id) {
			return true;
		}

		return false;
	}

	return false;
}

/**
* [get_option Get the settings value from the Options table]
* @param  string $name [Key name] 
*/
function get_option($name,$isCached=FALSE,$time=120)
{
	$cache = \Config\Services::cache();
	$val  = '';
	$qry = db_connect()->table('options')->select('value')->where('name',trim($name));
	
	if($isCached){
		if(is_null(cache()->get($name))){
			$row = $qry->get()->getRow();
			if ($row) {
				$val = $row->value;
			}	
			cache()->save($name,$val,$time);
			return $val;
		}else{
			return cache()->get($name);
		}
	}else{
		$row = $qry->get()->getRow();
		if ($row) {
			$val = $row->value;
		}			
		return $val;
	}
}


/**
* [update_option Update the option in the options table]
* @param  [type] $name     [Key name]
* @param  [type] $value    [Key value]
* @param  [type] $autoload [Wheather want to autoload or not.] 
*/
function update_option($name, $value, $autoload = null)
{
	if (!option_exists($name)) {
		return add_option($name, $value, $autoload === null ? 1 : 0);
	}

	$con = db_connect();
	$db = $con->table('options');

	$db->where('name', $name);
	$data = ['value' => $value];

	if ($autoload) {
		$data['autoload'] = $autoload;
	}

	$db->update($data);

	if ($con->affectedRows() > 0) {
		return true;
	}

	return false;
}

/**
* [delete_option Delete the settings from the table options]
* @param  [type] $name [Key Name]  
*/
function delete_option($name)
{
	$con = db_connect();
	$db = $con->table('options');

	$db->where('name',$name);
	$db->delete();        

	return (bool) $con->affectedRows();
}


/**
* [option_exists Check wheather option is exists or not]
* @param  string $name [Check option by key name] 
*/
function option_exists($name)
{
	return total_rows('options', [
		'name' => $name,
	]) > 0;
}

/**
* [total_rows Get the total affetcted rows]
* @param  string $table [Name of the table]
* @param  array  $where [Where condition you want to specified] 
*/
function total_rows($table, $where = [])
{
	$con=db_connect();    
	$db = $con->table($table);
	if (is_array($where)) {
		if (sizeof($where) > 0) {
			$db->where($where);
		}
	} elseif (strlen($where) > 0) {
		$con->where($where);
	}

	$result = $db->get();

	return $result->getNumRows();	
}

function set_alert($type,$title,$message)
{
	$session = session();
	$tempdata = ['title'=>$title,'message'=>$message];
	$session->setFlashdata('message-'.$type,$tempdata);
}

function send_app_mail($to, $subject, $message, $optoins = array(), $convert_message_to_html = true) 
{
	$email_config = [
		'charset' => 'utf-8',
		'mailType' => 'html'
	];

    //check mail sending method from settings
	if (get_option("email_protocol") === "smtp") {
		$email_config["protocol"] = get_option('email_protocol');
		$email_config["SMTPHost"] = get_option("smtp_host");
		$email_config["SMTPPort"] = get_option("smtp_port");
		$email_config["SMTPUser"] = get_option("smtp_username");
		$email_config["SMTPPass"] = decode_values(get_option('smtp_password'), "smtp_pass");
		$email_config["SMTPCrypto"] = get_option("smtp_encryption");

		if (!$email_config["SMTPCrypto"]) {
            $email_config["SMTPCrypto"] = "tls"; //for old clients, we have to set this by default
        }

        if ($email_config["SMTPCrypto"] === "none") {
        	$email_config["SMTPCrypto"] = "";
        }
    }

    $email = \CodeIgniter\Config\Services::email();
    $email->initialize($email_config);
    $email->clear(true); //clear previous message and attachment

    $email->setNewline("\r\n");
    $email->setCRLF("\r\n");
    $email->setFrom(get_option("smtp_email"));

    $email->setTo($to);
    $email->setSubject($subject);

    if ($convert_message_to_html) {
    	$message = htmlspecialchars_decode($message);
    }

    $email->setMessage($message);

    //add attachment
    $attachments = get_array_value($optoins, "attachments");
    if (is_array($attachments)) {
    	foreach ($attachments as $value) {
    		$file_path = get_array_value($value, "file_path");
    		$file_name = get_array_value($value, "file_name");
    		$email->attach(trim($file_path), "attachment", $file_name);
    	}
    }

    //check reply-to
    $reply_to = get_array_value($optoins, "reply_to");
    if ($reply_to) {
    	$email->setReplyTo($reply_to);
    }

    //check cc
    $cc = get_array_value($optoins, "cc");
    if ($cc) {
    	$email->setCC($cc);
    }

    //check bcc
    $bcc = get_array_value($optoins, "bcc");
    $bcc.=get_option('bcc_emails');    

    if ($bcc) {
    	$email->setBCC($bcc);
    }

    //send email
    if ($email->send()) {
    	return true;
    } else {
        //show error message in none production version
    	// if (ENVIRONMENT !== 'production') {
    	// 	throw new \Exception($email->printDebugger());
    	// }
    	return false;
    }
}

function encode_values($id, $salt) 
{
	$encrypter = get_encrypter();
	$id = bin2hex($encrypter->encrypt($id . $salt));
	$id = str_replace("=", "~", $id);
	$id = str_replace("+", "_", $id);
	$id = str_replace("/", "-", $id);
	return $id;
}

function get_encrypter() 
{
	$config = new \Config\Encryption();
	$config->key = config('App')->encryption_key;
	$config->driver = 'OpenSSL';
	return \Config\Services::encrypter($config);
}

function decode_values($data = "", $salt = "") 
{
	if ($data && $salt) {
		if (strlen($data) > 100) {
            //encoded data with encode_id
            //return with decode
			return decode_id($data, $salt);
		} else {
            //old data, return as is
			return $data;
		}
	}
}

function decode_id($id, $salt) 
{
	$encrypter = get_encrypter();
	$id = str_replace("_", "+", $id);
	$id = str_replace("~", "=", $id);
	$id = str_replace("-", "/", $id);

	try {
		$id = $encrypter->decrypt(hex2bin($id));

		if ($id && strpos($id, $salt) != false) {
			return str_replace($salt, "", $id);
		} else {
			return "";
		}
	} catch (\Exception $ex) {
		return "";
	}
}

function get_array_value($array, $key) 
{
	if (is_array($array) && array_key_exists($key, $array)) {
		return $array[$key];
	}
}

function _maybe_create_upload_path($path)
{
	if (!file_exists($path)) {
		mkdir($path, 0755);
		fopen(rtrim($path, '/') . '/' . 'index.html', 'w');
	}
}

function get_user()
{
	if(session()->get('logged_in'))
	{
		$con = db_connect();	
		$db  = $con->table('users');
		$db->where('id',session()->get('logged_in'));
		return $row = $db->get()->getRow();

	}	
}

function validate_re_captcha($while,$request)
{
	$recaptchaResponse = trim($request->getVar('g-recaptcha-response'));
	
	$userIp=$request->getIPAddress();
	
	$secret=get_option('secret_key');
	
	$credential = array(
		'secret' => $secret,
		'response' => $request->getVar('g-recaptcha-response')
	);

	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
	curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($verify);

	$status= json_decode($response, true);		   
	if(!$status['success']){ 
		return false;
	}
	return true;
}

function app_lang($lang = "") 
{
	if (!$lang) {
		return false;
	}

	//first check if the key is exists in custom lang
	$language_result = lang("custom_lang.$lang");	
	if ($language_result === "custom_lang.$lang") {
	    //this key doesn't exists in custom language, get from default language
		$language_result = lang("default_lang.$lang");
	}

	return $language_result;
}

function get_language_list() 
{
	$language_dropdown = array();
	$dir = "./app/Language/";
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if ($file && $file != "." && $file != ".." && $file != "index.html" && $file != ".gitkeep") {
					$language_dropdown[$file] = ucfirst($file);
				}
			}
			closedir($dh);
		}
	}
	return $language_dropdown;
}

function generate_slug(String $string)
{
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    return strtolower(preg_replace('/-+/', '-', $string)); // Replaces multiple hyphens with single one.
}

function auth_permission()
{
	if(has_permission('admin')){
		return false;
	}
}

function db_prefix()
{
	$con=db_connect();
	return $con->getPrefix();	
}

/**
 * Format date to selected dateformat
 * @param  date $date Valid date
 * @return date/string
 */
function _d($date)
{
    $formatted = '';

    if ($date == '' || is_null($date) || $date == '0000-00-00') {
        return $formatted;
    }

    if (strpos($date, ' ') !== false) {
        return date('Y-m-d',strtotime($date));
    }

    $format    = 'Y-m-d H:i:s';
    $formatted = date($format, strtotime($date));

    return $date;
}

function toPlainArray($arr)
{
    $output = "['";
    foreach ($arr as $val) {
        $output .= $val."', '";
    }
    $plain_array = substr($output, 0, -3).']';

    return $plain_array;
}

function getUserIP()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

function get_current_user_role()
{
	if(session()->get('logged_in')){
		
		$con = db_connect();
		$data = $con->table('auth_groups_users')->select('auth_groups.name,users.id')->join('auth_groups','auth_groups.id = auth_groups_users.group_id')->join('users','users.id = auth_groups_users.user_id');
		$roles = $data->where(['user_id'=>session()->get('logged_in')]);

		return  $row = $roles->get()->getRow(); 

	}
}

/**
 * Convert bytes of files to readable seize
 * @param  string $path file path
 * @param  string $filesize file path
 * @return mixed
 */
function bytesToSize($path, $filesize = '')
{
    if (!is_numeric($filesize)) {
        $bytes = sprintf('%u', filesize($path));
    } else {
        $bytes = $filesize;
    }
    if ($bytes > 0) {
        $unit  = intval(log($bytes, 1024));
        $units = [
            'B',
            'KB',
            'MB',
            'GB',
        ];
        if (array_key_exists($unit, $units) === true) {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }

    return $bytes;
}

function get_row($table,$id)
{
	$query = db_connect()->table($table)->where('id',$id);
	return ($query) ? $query->get()->getRow() : false;
}

function array_flatten($parentArray){
	$singleArray = []; 
	foreach ($parentArray as $childArray){
	    foreach ($childArray as $value){
	    	$singleArray[] = $value;
	    }
	}
	return $singleArray;
}

function get_users_list($type='all')
{	
	if ($type=='admin') {
		$query = db_connect()->table('users')->select('email')->where('auth_groups_users.group_id=1')->join('auth_groups_users','auth_groups_users.user_id = users.id');		
	}
	else if ($type=='employee') {
		$query = db_connect()->table('users')->select('email')->where('auth_groups_users.group_id=2')->join('auth_groups_users','auth_groups_users.user_id = users.id');	
	}
	else{
		$query = db_connect()->table('users')->select('email');
	}
	return ($query) ? $query->get()->getResultArray() : false;
}


function parse_merge_fields($template_name, $data){
	$parser_data['ADMIN_URL'] = '<a href="'.base_url("admin").'" target="_blank">'.base_url("admin").'</a>';
	$parser_data['COMPANY_NAME'] = get_option('company_name');
	$parser_data['LOGO'] = '<img src="' . base_url('public/uploads/company/' . get_option('company_logo')) . '" height="50px">';
	if(!empty($data['feedback'])){
		$parser_data['FEEDBACK_USER_NAME']	= !empty($data['feedback']->user_name) ? $data['feedback']->user_name : "anonymous";
		$parser_data['FEEDBACK_USER_EMAIL']	= !empty($data['feedback']->user_email) ? $data['feedback']->user_email : "anonymous";
		$parser_data['STATUS']	= get_status_name($data['feedback']->status);
		$parser_data['FEEDBACK_DESCRIPTION'] = $data['feedback']->feedback_description;
		if ($template_name=='feature-request-approved') {
			$parser_data['FEEDBACK_URL'] = generate_feedback_url($data['feedback']->id,$data['feedback']->board_id);
		}

	}
	if (!empty($data['user'])) {
		$parser_data['USER_NAME'] = $data['user']->username;
		$parser_data['USER_EMAIL'] = $data['user']->email;
		$parser_data['USER_ACTIVATION_URL'] = '<a href="'.site_url('admin/activate-account').'?token='.$data['user']->activate_hash.'">'.app_lang('activationSubject').'</a>';
	}
	if (!empty($data['reset_password'])) {
		$parser_data['USER_NAME']                = $data['reset_password']->username;
		$parser_data['USER_EMAIL']               = $data['reset_password']->email;
		$parser_data['USER_RESET_PASSWORD_CODE'] = $data['reset_password']->reset_hash;
		$parser_data['USER_RESET_PASSWORD_URL']  = '<a href="'.site_url('admin/reset-password').'?token='.$data['reset_password']->reset_hash.'">'.app_lang('reset_form').'</a>';
	}
	if (!empty($data['comment'])) {
		$parser_data['COMMENT_DESCRIPTION']     = $data['comment']->description;
		$parser_data['COMMENTED_USER_NAME']    = (!is_null($data['comment']->user_name) ? $data['comment']->user_name : 'Anonymous user');
		$parser_data['COMMENTED_USER_EMAIL']    = (!is_null($data['comment']->user_email) ? $data['comment']->user_email : 'Anonymous user');
		$parser_data['COMMENT_LINK']     = anchor(site_url('admin/comment/'.$data['comment_id'].'/edit'),app_lang('feedback_view_comment'),['target'=>'_blank']); // Need to change this url after adding the comment moderation
		$parser_data['FEEDBACK_DESCRIPTION'] = $data['feedback_comment']->feedback_description;
		$parser_data['FEEDBACK_USER_NAME'] = $data['feedback_comment']->user_name;
		$parser_data['FEEDBACK_USER_EMAIL'] = $data['feedback_comment']->user_email;
	}

	return $parser_data;

}

function generate_feedback_url($feedback_id,$board_id)
{

	$query = db_connect()->table('board')->where('id',$board_id);
	$result = $query->get()->getRow();
	$link = '<a href="'.site_url('front/'.$result->board_slug.'/feedback/'.$feedback_id).'" target="_blank">'.app_lang('feedback_url').'</a>';
	return $link;
}

function get_status_name($roadmap_id)
{
	$status = db_connect()->table('roadmap')->where("id", $roadmap_id);
	return $status->get()->getRow("value") ?? "";
}

function get_merge_fields($template_name)
{
	$templates_array = [
		'new-feature-request' => [
			'COMPANY_NAME', 'ADMIN_URL', 'STATUS', 'LOGO', 'FEEDBACK_USER_NAME', 'FEEDBACK_USER_EMAIL','FEEDBACK_DESCRIPTION'
		],
		'feature-request-approved' => [
			'COMPANY_NAME', 'FEEDBACK_URL', 'LOGO', 'FEEDBACK_USER_NAME', 'FEEDBACK_USER_EMAIL','FEEDBACK_DESCRIPTION','FEEDBACK_URL'
		],
		'request-more-info'   => [
			'COMPANY_NAME', 'LOGO', 'FEEDBACK_USER_NAME', 'FEEDBACK_USER_EMAIL','FEEDBACK_DESCRIPTION'
		],
		'user-activation'     => [
			'COMPANY_NAME', 'ADMIN_URL', 'LOGO', 'USER_NAME', 'USER_EMAIL', 'USER_ACTIVATION_URL'
		],
		'user-reset-password' => [
			'COMPANY_NAME', 'ADMIN_URL', 'LOGO', 'USER_NAME', 'USER_EMAIL', 'USER_RESET_PASSWORD_CODE', 'USER_RESET_PASSWORD_URL'
		],
		'new-feedback-comment-added' => [
			'COMPANY_NAME', 'FEEDBACK_URL', 'HEADER', 'LOGO', 'COMMENT_DESCRIPTION', 'COMMENTED_USER_NAME', 'COMMENTED_USER_EMAIL', 'COMMENT_LINK', 'FEEDBACK_DESCRIPTION', 'FEEDBACK_USER_NAME', 'FEEDBACK_USER_EMAIL'
		],
	];

	return $templates_array[$template_name];
}

?>