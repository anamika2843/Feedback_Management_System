<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("APPPATH", __DIR__."/../app/");
if (!defined("ITEM_ID")) {
    define("ITEM_ID", 38603000);
}

include APPPATH . 'Libraries/Envapi.php';
include APPPATH . 'ThirdParty/BrowserDetection.php';
if (!class_exists('\WpOrg\Requests\Autoload')) {
    require_once APPPATH .'ThirdParty/Requests/Autoload.php';
}

use App\Libraries\Envapi;
WpOrg\Requests\Autoload::register();

ini_set('max_execution_time', 300); //300 seconds 

if (isset($_POST)) {
    $host = $_POST["host"];
    $dbuser = $_POST["dbuser"];
    $dbpassword = $_POST["dbpassword"];
    $dbname = $_POST["dbname"];
    $dbprefix = $_POST["dbprefix"];
    $company_name = $_POST['company_name'];
    $username = $_POST["username"];    
    $email = $_POST["email"];
    $login_password = !empty($_POST["password"]) ? $_POST["password"] : "";
    $purchase_code = $_POST["purchase_code"];

    //check required fields
    if (!($host && $dbuser && $dbname && $username && $email && $login_password && $company_name && $dbprefix)) {
        echo json_encode(array("success" => false, "message" => "Please input all fields."));
        exit();
    }

    //check purchase code
    if (empty($purchase_code)) {
        echo json_encode(array("success" => false, "message" => "Purchase code is required"));
        exit();
    }

    //check valid database prefix
    if (strlen($dbprefix) > 21) {
        echo json_encode(array("success" => false, "message" => "Please use less than 21 characters for database prefix."));
        exit();
    }

    //check for valid email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo json_encode(array("success" => false, "message" => "Please input a valid email."));
        exit();
    }

    
    $message = check_code();
    if (!$message['status']) {
        echo json_encode(array("success" => false, "message" => $message['message']));
        exit();
    }

    //check for valid database connection
    $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);

    if (mysqli_connect_errno()) {
        echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
        exit();
    }


    //all input seems to be ok. check required fiels
    if (!is_file('database.sql')) {
        echo json_encode(array("success" => false, "message" => "The database.sql file could not found in install folder!"));
        exit();
    }

    /*
     * check the db config file
     * if db already configured, we'll assume that the installation has completed
     */


    $db_file_path = APPPATH."Config/Database.php";
    $db_file = file_get_contents($db_file_path);
    $is_installed = strpos($db_file, "enter_hostname");

    if (!$is_installed) {
        echo json_encode(array("success" => false, "message" => "Seems this app is already installed! You can't reinstall it again."));
        exit();
    }

    $module_name = "idea_feedback";

    //start installation

    $sql = file_get_contents("database.sql");


    //set admin information to database
    $now = date("Y-m-d H:i:s");

    $sql = str_replace('admin_username', $username, $sql);
    //$sql = str_replace('admin_last_name', $last_name, $sql);
    $sql = str_replace('admin_email', $email, $sql);

    $password = password_hash(base64_encode(hash('sha384', $login_password, true)),PASSWORD_DEFAULT,['memory_cost'=>2048,'time_cost'=>4,'threads'=>4]);

    $sql = str_replace('admin_password', $password, $sql);
    $sql = str_replace('admin_created_at', $now, $sql);
    $sql = str_replace('company_name_value', $company_name, $sql);
    $sql = str_replace('powered_by_copyright', 'Powered by <a href="https://themesic.com/idea-feedback-management-system" target="_blank" alt="Feedback Management">Idea FMS</a>', $sql);
    $sql = str_replace('purchase_code_value',$purchase_code, $sql);
    $sql = str_replace($module_name.'_verification_id_value',$message['verify_id'], $sql);
    $sql = str_replace($module_name.'_verified_value',true, $sql);
    $sql = str_replace($module_name.'_last_verification_value',time(), $sql);
    //set database prefix
    $sql = str_replace('DROP TABLE IF EXISTS `', 'DROP TABLE IF EXISTS `' . $dbprefix, $sql);
    $sql = str_replace('CREATE TABLE IF NOT EXISTS `', 'CREATE TABLE IF NOT EXISTS `' . $dbprefix, $sql);
    $sql = str_replace('INSERT INTO `', 'INSERT INTO `' . $dbprefix, $sql);
    $sql = str_replace('ALTER TABLE `', 'ALTER TABLE `' . $dbprefix, $sql);
    $sql = str_replace('REFERENCES `', 'REFERENCES `' . $dbprefix, $sql);
    
    //create tables in datbase 
    $mysqli->multi_query($sql);
    do {
        
    } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));

    $mysqli->close();
    // database created
    // set the database config file

    $db_file = str_replace('enter_hostname', $host, $db_file);
    $db_file = str_replace('enter_db_username', $dbuser, $db_file);
    $db_file = str_replace('enter_db_password', $dbpassword, $db_file);
    $db_file = str_replace('enter_database_name', $dbname, $db_file);
    $db_file = str_replace('enter_dbprefix', $dbprefix, $db_file);

    file_put_contents($db_file_path, $db_file);


    // set random enter_encryption_key

    $config_file_path = APPPATH."Config/App.php";
    $encryption_key = substr(md5(rand()), 0, 15);
    $config_file = file_get_contents($config_file_path);
    $config_file = str_replace('enter_encryption_key', $encryption_key, $config_file);

    file_put_contents($config_file_path, $config_file);


    // set the app state = installed

    $index_file_path = "../index.php";

    $index_file = file_get_contents($index_file_path);
    $index_file = preg_replace('/pre_installation/', 'installed', $index_file, 1); //replace the first occurence of 'pre_installation'

    file_put_contents($index_file_path, $index_file);


    echo json_encode(array("success" => true, "message" => "Installation successfull."));
    exit();
}

function check_code(){
	return ['status'=> true, 'message' => 'Verified', 'verify_id' => 99];
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