<?php

return [
     // Exceptions
    'invalidModel'              => 'The {0} model must be loaded before use.',
    'userNotFound'              => 'Unable to locate a user with ID = {0, number}.',
    'noUserEntity'              => 'User Entity must be provided for password validation.',
    'tooManyCredentials'        => 'You may only validate against 1 credential other than a password.',
    'invalidFields'             => 'The "{0}" field cannot be used to validate credentials.',
    'unsetPasswordLength'       => 'You must set the `minimumPasswordLength` setting in the Auth config file.',
    'unknownError'              => 'Sorry, we encountered an issue sending out your email. Please try again later.',
    'notLoggedIn'               => 'You must be logged in, in order to access this page.',
    'notEnoughPrivilege'        => 'You do not have sufficient permissions to access this page.',

    // Registration
    'registerDisabled'          => 'Sorry, new user accounts are not allowed at this time.',
    'registerSuccess'           => 'Welcome on board! Please login using your credentials.',
    'registerCLI'               => 'New user created: {0}, #{1}',

    // Activation
    'activationNoUser'          => 'Unable to locate a user with this activation code.',
    'activationSubject'         => 'Activate your account',
    'activationSuccess'         => 'Please confirm your account by clicking the activation link you received via email.',
    'activationResend'          => 'Resend activation email.',
    'notActivated'              => 'This user account is not activated yet.',
    'errorSendingActivation'    => 'Failed to send activation email at: {0}',

    // Login
    'badAttempt'                => 'Unable to log you in. Please check your credentials.',
    'loginSuccess'              => 'Horay, welcome!',
    'invalidPassword'           => 'Unable to log you in. Please check your password.',

    // Forgotten Passwords
    'forgotDisabled'            => 'Reseting password option is not possible at this time.',
    'forgotNoUser'              => 'Unable to locate a user with this email.',
    'forgotSubject'             => 'Password Reset Instructions',
    'resetSuccess'              => 'Successfully changed. Please login with your new password.',
    'forgotEmailSent'           => 'A security token has been emailed to you. Please paste it below to continue.',
    'errorEmailSent'            => 'Unable to send email with password reset instructions to: {0}',
    'errorResetting'            => 'Unable to send reset password instructions to {0}',

    // Passwords
    'errorPasswordLength'       => 'Passwords must be at least {0, number} characters long.',
    'suggestPasswordLength'     => 'Pass phrases - up to 255 characters long - make more secure passwords that are easy to remember.',
    'errorPasswordCommon'       => 'Password must not be a common password.',
    'suggestPasswordCommon'     => 'The password was checked against over 65k commonly used passwords or passwords that have been leaked through hacks.',
    'errorPasswordPersonal'     => 'Passwords cannot contain re-hashed personal information.',
    'suggestPasswordPersonal'   => 'Variations on your email address or username should not be used for passwords.',
    'errorPasswordTooSimilar'    => 'Password is too similar to the username.',
    'suggestPasswordTooSimilar'  => 'Do not use parts of your username in your password.',
    'errorPasswordPwned'        => 'The password {0} has been exposed due to a data breach and has been seen {1, number} times in {2} of compromised passwords.',
    'suggestPasswordPwned'      => '{0} should never be used as a password. If you are using it anywhere change it immediately.',
    'errorPasswordPwnedDatabase' => 'a database',
    'errorPasswordPwnedDatabases' => 'databases',
    'errorPasswordEmpty'        => 'A Password is required.',
    'passwordChangeSuccess'     => 'Password changed successfully',
    'userDoesNotExist'          => 'Password was not changed. User does not exist',
    'resetTokenExpired'         => 'Sorry. Your reset token has expired.',
    'confirm_password_required' => 'Confirm password field is required',
    'confirm_password_not_match' => 'Confirm password field does not match the password field',

    // Groups
    'groupNotFound'             => 'Unable to locate group: {0}.',

    // Permissions
    'permissionNotFound'        => 'Unable to locate permission: {0}',

    // Banned
    'userIsBanned'              => 'Your account has been banned, sorry.',

    // Too many requests
    'tooManyRequests'           => 'Too many requests. Please wait {0, number} seconds.',

    // Login views
    'home'                      => 'Home',
    'current'                   => 'Current',
    'forgotPassword'            => 'Forgot Your Password?',
    'enterEmailForInstructions' => 'No problem! Enter your email below and we will send instructions to reset your password.',
    'login_email'               => 'Email',
    'emailAddress'              => 'Email Address',
    'sendInstructions'          => 'Send Instructions',
    'loginTitle'                => 'Login',
    'loginAction'               => 'Login',
    'rememberMe'                => 'Remember me',
    'needAnAccount'             => 'Need an account?',
    'forgotYourPassword'        => 'Forgot your password?',
    'password'                  => 'Password',
    'repeatPassword'            => 'Repeat Password',
    'emailOrUsername'           => 'Email or username',
    'username'                  => 'Username',
    'register'                  => 'Register',
    'signIn'                    => 'Sign In',
    'alreadyRegistered'         => 'Already registered?',
    'weNeverShare'              => 'We\'ll never share your email with anyone else.',
    'resetYourPassword'         => 'Reset Your Password',
    'enterCodeEmailPassword'    => 'Enter the code you received via email, your email address, and your new password.',
    'token'                     => 'Token',
    'newPassword'               => 'New Password',
    'newPasswordRepeat'         => 'Repeat New Password',
    'resetPassword'             => 'Reset Password',

    //Settings
    'custom-javascript'            => 'Custom JS',
    'general'                      => 'General',
    'email'                        => 'Email',
    're-captcha'                   => 'Re-Captcha',
    'miscellaneous'                => 'Miscellaneous',
    'policy'                       => 'Terms & Policies',
    'setting_submit'               => 'Submit',
    'purchase-code'                => 'License Code',
    'testing_smtp_mail_success_message' => 'This is test SMTP email. <br />If you received this message that means that your SMTP settings are set correctly.',
    'testing_smtp_mail_success_message_success' => 'Seems like your SMTP settings are set correctly. Check your email now.',
    'testing_smtp_mail_success_message_fail' => 'Seems like your SMTP settings are not set correctly. Check your settings.',
    'test_email_subject'           => 'SMTP Setup Testing',
    'human_verification_failed' => 'Human verification failed',
    'select_file_to_upload' => 'Please Select File to upload',
    'onlyExtension' => 'Only jpg,jpeg,png are allowed',
    'only_image' => 'Only Images are allowed',

    //Admin Registration
    'register_welcome'             => 'Horay, welcome!',
    'register_msg'                 => '<span>It only takes a <span class="text-success">few seconds</span> to create your account</span>',
    'have_account'                 => 'Already registered',
    'register_recover_password'    => 'Recover Password',
    'create_account'               => 'Create Account',
    'sign_in'                      => 'Sign in',

    //Admin Forget Password
    'forgot_your_password'         => 'Forgot your Password',
    'forgot_email'                 => 'Email',
    'signin_account'               => 'Sign in existing account',
    'recover_password'             => 'Recover Password',

    //Admin Login
    'welcome_back'                 => 'Welcome back!',
    'login_msg'                    => 'Please sign in to your account below.',
    'logged_in'                    => 'Keep me logged in',
    'no_account'                   => 'No account',
    'signup_now'                   => 'Sign up now!',
    'login_recover_password'       => 'Recover Password',
    'login_to_dashboard'           => 'Login to Dashboard',

    //Welcome Meassge
    'dashboard'                    =>'Feedback Management Platform Dashboard',

    //Topbar
    'logout'                       => 'Log out',

    //RightSidebar
    'server_status'                => 'Servers Status',

    //LeftSidebar
    'reports' => 'Reporting',
    'users' => ' Users',
    'categories' => 'Categories',
    'road_map' => 'Feedback Roadmap',
    'board' => 'Feedback Products',
    'feedback' => 'Feedback Submissions',
    'email-template' => 'Email Templates',
    'system_setting' => 'System Settings',
    'user_staff' =>  ' Users & Staff',
    'overview' =>'Overview',
    'menu'  => 'Menu',
    'data'   =>  'Data',
    'setting_menu'  => 'Settings',

    //Dashboards
    'user-total' => 'Feedback Users',
    'comments-total' => 'Overall Comments',
    'roadmap-changes-total' => 'Roadmap Statuses',
    'feature-requests-total' => 'Feedback Ideas',
    'company_agent_status' => 'Company Agents Status',
    'select-board' => 'Select Product',
    'select-board-range' => 'Select Date Range',
    'filter' => 'Filter',
    'feature_request_chart' => 'Feature Request Chart',
    'chart_total' => 'Total',
    'top_ten_feedback' => 'Top Ten Feedback Ideas',
 

    //User Management
    'user' => 'user', 
    'user-name' => 'Name',
    'user-email' => 'Email',
    'user-action' => 'Action',
    'user_edit' =>'Edit User',
    'user_editusername' => 'User Name',
    'user_edituseremail' => 'User Email',
    'user_editclose' => 'Close',
    'user_editsave' => 'Save changes',
    'user-name-is-required' => 'User Name is required',
    'user_name_required' => 'User Name is required',
    'user_name_exists' => 'Name already exists',
    'user_email_required' => 'User Email is required',
    'email_exists' => 'Email already exists',
    'user_update' => 'User updated successfully',
    'user_delete' => 'User deleted successfully',

    //Front user
    'front-username'  => 'Enter User Name',
    'front-useremail' => 'Enter User Email',
 
    //Category
    'category' => 'Category',
    'category-title' => 'Title',
    'category-description' => 'Description',
    'category-action' => 'Action',
    'create-category' => 'Create Category',
    'category_edit' => 'Category',
    'category_edittitle' => 'Title',
    'category_editdescription' => 'Description',
    'category_editsave' => 'Save',
    'category_description' => 'Category Description',
    'category_title' => 'Category Title',
    'category_title_required' => 'Category Title is required',
    'category_title_exists' => 'Category Title already exists',
    'category_desc_required' => 'Category description is required',
    'category_created_successfully' => 'New Category created Successfully',
    'category_update_successfully' => 'Category updated Successfully',
    'category_delete_successfully' => 'Category deleted successfully',

    //Roadmap
    'roadmap' => 'Roadmap',
    'roadmap-value' => 'Value',
    'roadmap-action' => 'Action',
    'roadmap_edit' => 'Edit Roadmap',
    'roadmap_editclose' => 'Close',
    'roadmap_editsave' => 'Save changes',
    'roadmap_required' => 'Roadmap Name is required',
    'roadmap_exists' => 'Roadmap name already exists',
    'roadmap_updated_successfully' => 'Roadmap updated successfully',

    //Boards
    'board' => 'Board',
    'boards-name' => 'Name',
    'boards-introtxt' => 'Intro Text',
    'boards-action' => 'Action',
    'boards-create' => 'Create Boards',
    'board_editname' => 'Name',
    'board_editintrotxt' => 'Intro Text',
    'board_editsave' => 'Save',
    'select_boards'=>'Select Board',
    'board_title' => 'Board',
    'board-name' => 'Enter Board Name',
    'board_name_required' => 'Board name is required',
    'board_intro_text'=> 'Intro text is required',
    'board_exists' => 'Board name already exists',
    'board-introtext' => 'Some introduction text can be included here',
    'board_create_successfully' => 'New Board created successfully',
    'board_update_successfully' => 'Board updated successfully',
    'cant_delete_board' => 'You cant delete the board',
    'board_delete' =>'Board delete successfully',

    //Feedbacks
    'feedback' => 'Feedback',
    'feedback-username' => 'User Name',
    'feedback-useremail' => 'User Email',
    'feedback-status' => 'Status',
    'feedback-category' => 'Category',
    'feedback-approvalstatus' => 'Approval Status',
    'feedback-action' => 'Action',
    'feedback_edittitle' => 'Edit Feedback',
    'feedback_view_info_title' => 'View Information',
    'feedback_editusername' => 'User Name',
    'feedback_edituseremail' => 'User Email',
    'feedback_editdescription' => 'Feedback Description',
    'feedback_editdestatus' => 'Status',
    'feedback_editcategory' => 'Category',
    'feedback_editapprovalstatus' => 'Check this box to Approve/Undo',
    'feedback_editclose' => 'Close',
    'feedback_editsave' => 'Save changes',
    'select_category' => 'Select Category',
    'anonymous' => 'Anonymous',
    'no_comments' => 'No Comments',
    'feedback_description_required' => 'Feedback description is required',
    'select_Categories' => 'Select at least one category',
    'select_board' => 'Select at least one board',
    'select_roadmap' => 'Select at least one roadmap status',
    'feedback_comments' => 'Feedback Comments',
    'feedback_exists'   => 'Feedback Already Exists',
    'feedback_title'    => 'Feedback',
    'approved'          => 'Approved',
    'view_and_approve'  => 'View & Approve',
    'feedback_board_title' => 'Board',
    'pending_moderation' => 'Pending moderation',
    'dis_approved' => 'Dis-Approved',
    'feedback-total-comments' => 'Total Comments',
    'feedback-view-comments' => 'View Comments',
    'feedback-comments-description' => 'Comment Description',
    'feedback-comments' => 'View Comments',
    'feedback-all-comments' => 'Comments',
    'feedback_store_successfully' => 'Feedback stored successfully',
    'feedback_update_successfully' => 'Feedback updated successfully',
    'mail_send_successfully' => 'Email sent successfully',
    'fail_to_send_mail' => 'Fail to send email.',
    'check_your_smtp_setting' => 'Failed to send email <br> Kindly check your SMTP settings!',
    'feedback_deleted_successfully' => 'Feedback deleted successfully',
    'feedback_comments_status_chaned_successfully' => 'Comment status changed successfully',
    'feedback_comments_status_chaned_failed' => 'Failed to change comment status',
    'feedback_comments_dateadded' => 'Commented on',
    'feedback_comments_updated' => 'Comment updated successfully.',
    'feedback_comments_updated_fail' => 'Failed to update comment.',
    'feedback_comments_deleted' => 'Feedback Comment deleted successfully.',
    'feedback_comments_deleted_fail' => 'Failed to delete comment.',
    'feedback_view_comment' => 'View Comment.',
    'comment_id' => 'CommentID',
    'feedback_items' => 'Feedback Ideas',
    'approved' => 'Approved',
    'feedback_url' => 'Feedback URL',

    //Save Admin Feedback
    'admin_feedback_title'         => 'New Feedback Item',
    'admin_feedback_description'   => 'Description',
    'admin_feedback_category'      => 'Category',
    'admin_feedback_board'         => 'Board',
    'admin_feedback_status'        => 'Status',
    'save'                         => 'Save',
    'request_more_info'            => 'Request More Information',

    //Email Templates
    'email_templates' => 'Email Templates',
    'update_success' => 'Email template is updated successfully',

    //Settings GENERAL
    'setting_companylogo' => 'Company Logo',
    'setting_favicon' => 'Favicon',
    'setting_companyname' => 'Company Name',
    'setting_Companymaindomain' => 'Company Domain',
    'setting_language' => 'Language',
    'setting_copyrighttext' => 'Copyright',
    'setting_disablecopyright' => 'Disable Copyright',
    'setting_allowposting' => 'Allow Posting - Upvoting without an account',
    'allow_guest_posting'  => 'Allow guests to submit feedback ideas (anonymous submissions)',
    'allow_guest_commenting'  => 'Allow guests to comment (anonymous comments)',
    'setting_expiry_date' => 'Set the number of the days that a feedback item will be considered as NEW',
    'settings_updated' => 'Success! Settings saved.',

    //Settings Email
    'email_protocol' => 'Mail Protocol',
    'email-smtp' => 'SMTP',
    'email_sendmail' => 'SendMail',
    'email_mail' => 'PHP Mail',
    'email_encryption' => 'Email Encryption Type',
    'email_smtphost' => 'Host',
    'email_smtpport' => 'Port',
    'email_smtpemail' =>'Email',
    'email_smtpusername' => 'Username',
    'email_smtppassword' => 'Password',
    'email_charset' => 'Email Charset',
    'email_bcc' => 'BCC All Emails To',
    'reply_to' =>'Reply To',
    'email_signature' => 'Email Signature',
    'email_predefinedheader' => 'Predefined Header',
    'email_predefinedfooter' => 'Predefined Footer',
    'email_sendtestmain' => 'Send a test Email',
    'email_sure' => 'Enter your email address for the test email:',
    'email_send' => 'Send',
    'email_required'=>'Email is required',
    'test_email'=>'Test Email',
    'disable' => 'Disable',
    'enable' => 'Enable',

    //Settings RE-CAPTCHA
    'recaptcha_sitekey' => 'Site Key',
    'recaptcha_secretkey' => 'Secret Key',
    'recaptcha_login' => 'Enable While Login',
    'recaptcha_registartion' => 'Enable While Registration',
    'recaptcha_password' => 'Enable While Forgot Password',
    'recaptcha_reset'   => 'Enable While Reset Password',
    'recaptcha_description'  => 'reCaptcha v2 (tickbox) has to be used. You can credentials',
    'recaptcha_button_here' => 'here',

    //Settings MISCELLANEOUS
    'mis_table' => 'Activate scroll responsive backend tables',
    'mis_yes' => 'Yes',
    'mis_no' => 'No',
    'mis_limit' => 'How many items to list in backend tables per page?',

    //Settings Policy
    'policy_cookiearea' => 'Cookies Consent',
    'policy_terms' => 'Terms of Use',
    'policy_privacy' => 'Privacy Policy',
    'policy_cookiesnotice' => 'Cookies consent headline',
    'policy_buttontxt' => 'Consent button text',
    'policy_cookielongtxt' => 'Description text (supports HTML)',
    'policy_pre' => 'Live Preview',
    'close' => 'Close',
    'terms_of_usage' => 'Terms Of Use',

    //Settings Custom JavaScript
    'js_header' => 'Custom JavasScript for header area',
    'js_footer' => 'Custom JavasScript for footer area',

    //common
    'delete'   => 'Delete',
    'edit'     => 'Edit',
    'sr_no'    => 'No',
    'success'  => 'Success',
    'view_info' => 'View Information',

    //Add new feedback
    'add_new_entry'      => 'Add New Entry',
    'new_feedback_title' => 'Title',

    //Members
    'staff_members' => 'Staff Members',
    'members_deleted_success' => 'Staff Member deleted successfully',
    'members_deleted_fail' => 'Fail to delete staff member',
    'add_member' => 'Add Staff Member',
    'member_role' => 'Role',
    'member_updated' => "Staf Member updated successfully",
    'fail_to_member_updated' => "Fail to update staff member",
    'reset_form'=>'Reset Form',
    'members' => 'Members',

    //Chart
    'today'=>'Today',
    'this_week'=>'This Week',
    'this_month'=>'This Month',
    'last_month'=>'Last Month',
    'this_year'=>'This Year',
    'last_year'=>'Last Year',
    'custom'=>'Custom',
    'chart'=>'Chart',

    //Purchase Keys
    'purchase_key_required' => 'License key is required.',
    'something_went_wrong'  => 'Something went wrong.',
    'sold_time_not_found'   => 'Failed to verify your purchase. Please contact support #0003.',
    'invalid_purchase_key'  => 'License key is not valid.',
    'reactivate_purchase_key_admin' => 'License key verification failed. Please contact support #0004.',
    'reactivate_purchase_key_client' => 'License key verification failed. Please contact support #0005.',
    'error'                 => 'Error',

    //Server Status
    'server_status'                 => 'Local Server Information',
    'variable_name'                 => 'Variable Name',
    'server_info_value'             => 'Value',
    'os'                            => 'OS',
    'webserver'                     => 'Webserver',
    'webserver_user'                => 'Webserver User',
    'server_protocol'               => 'Server Protocol',
    'php_version'                   => 'PHP Version',
    'php_extension_curl'            => 'PHP Extension "curl" ',
    'php_extension_mbstring'        => 'PHP Extension "mbstring" ',
    'php_extension_intl'            => 'PHP Extension "intl" ',
    'php_extension_json'            => 'PHP Extension "json" ',
    'php_extension_mysqlnd'         => 'PHP Extension "mysqlnd" ',
    'php_extension_xml'             => 'PHP Extension "xml" ',
    'php_extension_gd'              => 'PHP Extension "gd" ',
    'mysql_version'                 => 'MySQL Version',
    'mysql_max_allowed_connections' => 'MySQL Max Allowed Connections',
    'maximum_packet_size'           => 'Maximum Packet Size',
    'sql_mode'                      => 'SQL mode',
    'max_input_vars'                => 'Max input vars',
    'upload_max_filesize'           => 'Upload max filesize',
    'post_max_size'                 => 'Post max size',
    'max_execution_time'            => 'Max execution time',
    'memory_limit'                  => 'Memory Limit',
    'environment'                   => 'Environment',
    'installation_path'             => 'Installation PATH',
    'base_url'                      => 'Base URL',
    
    //Frontend
    'frontendtitle'                 => 'Feedback Management Platform',

];