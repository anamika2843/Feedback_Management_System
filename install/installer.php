<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=Edge" >
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <link rel="icon" href="../favicon.ico" />
      <title>Idea Feedback Management System</title>
      <link rel='stylesheet' type='text/css' href='../assets/main.css' />
      <script type='text/javascript'  src='../assets/main.js'></script>
      <script type='text/javascript'  src='./assets/js/jquery-3.5.1.min.js'></script>
      <script type='text/javascript'  src='./assets/js/jquery-validation/jquery.form.js'></script>
      <script type='text/javascript'  src='./assets/js/jquery-validation/jquery.validate.min.js'></script>
      <script type='text/javascript'  src='./assets/js/feather-icons/feather.min.js'></script>
   </head>
   <body style="background-color: #fff; overflow-x: hidden;">
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <div class="mt-4">
               <div class="card card-install">
                  <div class="app-main__outer">
                     <div class="app-main__inner">
                        <div class="app-inner-layout">
                           <div class="app-inner-layout__header-boxed p-0">
                              <div class="app-inner-layout__header page-title-icon-rounded text-white bg-midnight-bloom">
                                 <div class="page-title-heading" style="font-size:30px">
                                    <center><b>Idea Feedback Management System</b></center>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="app-inner-layout__header">
                  <div class="mb-3">
                     <div role="group" class="btn-group-lg nav btn-group ">
                        <div  id="pre-installation" class=" col-sm-4 active btn btn-primary">Pre-Installation</div>
                        <div id="configuration" class=" col-sm-4 btn btn-primary">Configuration</div>
                        <div id="finished" class="col-sm-4 pe-3 btn btn-primary">Finished</div>
                     </div>
                  </div>
                  <div class="card-body no-padding">
                     <div id="alert-container"></div>
                     <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="pre-installation-tab">
                           <div class="section">
                              <p>1. Please configure your PHP settings to match following requirements:</p>
                              <hr />
                              <div>
                                 <table class="table">
                                    <thead>
                                       <tr>
                                          <th width="25%">PHP Settings</th>
                                          <th width="27%">Current Version</th>
                                          <th>Required Version</th>
                                          <th class="text-center">Status</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>PHP Version</td>
                                          <td><?php echo $current_php_version; ?></td>
                                          <td><?php echo $php_version_required; ?>+</td>
                                          <td class="text-center">
                                             <?php if ($php_version_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="section">
                              <p>2. Please make sure the extensions/settings listed below are installed/enabled:</p>
                              <hr />
                              <div>
                                 <table class="table">
                                    <thead>
                                       <tr>
                                          <th width="25%">Extension/settings</th>
                                          <th width="27%">Current Settings</th>
                                          <th>Required Settings</th>
                                          <th class="text-center">Status</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>MySQLi</td>
                                          <td> <?php if ($mysql_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($mysql_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>GD</td>
                                          <td> <?php if ($gd_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($gd_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>cURL</td>
                                          <td> <?php if ($curl_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($curl_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>mbstring</td>
                                          <td> <?php if ($mbstring_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($mbstring_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>intl</td>
                                          <td> <?php if ($intl_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($intl_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>json</td>
                                          <td> <?php if ($json_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($json_success) { ?>
                                             <i data-feather="check-circle" class="status-icon"></i> 
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>mysqlnd</td>
                                          <td> <?php if ($mysqlnd_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($mysqlnd_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>xml</td>
                                          <td> <?php if ($xml_success) { ?>
                                             On
                                             <?php } else { ?>
                                             Off
                                             <?php } ?>
                                          </td>
                                          <td>On</td>
                                          <td class="text-center">
                                             <?php if ($xml_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>date.timezone</td>
                                          <td> <?php
                                             if ($timezone_success) {
                                                 echo $timezone_settings;
                                             } else {
                                                 echo "Null";
                                             }
                                             ?>
                                          </td>
                                          <td>Timezone</td>
                                          <td class="text-center">
                                             <?php if ($timezone_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>zlib.output_compression</td>
                                          <td> <?php if ($zlib_success) { ?>
                                             Off
                                             <?php } else { ?>
                                             On
                                             <?php } ?>
                                          </td>
                                          <td>Off</td>
                                          <td class="text-center">
                                             <?php if ($zlib_success) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php } else { ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="section">
                              <p>3. Please make sure you have set the <strong>writable</strong> permission on the following folders/files:</p>
                              <hr />
                              <div>
                                 <table class="table">
                                    <tbody>
                                       <?php
                                          foreach ($writeable_files as $file) {
                                              ?>
                                       <tr>
                                          <td style="width:87%;"><?php echo basename($file); ?></td>
                                          <td class="text-center">
                                             <?php if (is_writeable(".." . $file)) { ?>
                                             <i data-feather="check-circle" class="status-icon" ></i>
                                             <?php
                                                } else {
                                                    $all_requirement_success = false;
                                                    ?>
                                             <i data-feather="x-circle" class="status-icon" ></i>
                                             <?php } ?>
                                          </td>
                                       </tr>
                                       <?php
                                          }
                                          ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="d-grid gap-2">
                              <button <?php
                                 if (!$all_requirement_success) {
                                     echo "disabled=disabled";
                                 }
                                 ?> class=" btn-square btn btn-primary btn-lg form-next"><i data-feather="chevron-right" class='icon'></i> Next</button>
                           </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="configuration-tab">
                           <form name="config-form" class="requires-validation" id="config-form" action="do_install.php" method="post">
                              <div class="section clearfix">
                                 <p>1. Please enter your company name.</p>
                                 <hr />
                                 <div>
                                    <div class="form-group clearfix mb-5">
                                       <div class="row">
                                          <label for="company_name" class=" col-md-3">Company Name</label>
                                          <div class="col-md-9">
                                             <input type="text" value=""  id="company_name"  name="company_name" class="form-control"  placeholder="Your Company Name" required />
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="section clearfix">
                                 <p>2. Please enter your database connection details.</p>
                                 <hr />
                                 <div>
                                    <div class="form-group clearfix mb-3">
                                       <div class="row">
                                          <label for="host" class=" col-md-3">Database Host</label>
                                          <div class="col-md-9">
                                             <input type="text" value="localhost" id="host"  name="host" class="form-control" required placeholder="Database Host (usually localhost)" />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group clearfix mb-3">
                                       <div class="row">
                                          <label for="dbuser" class=" col-md-3">Database User</label>
                                          <div class=" col-md-9">
                                             <input id="dbuser" type="text" value="" name="dbuser" class="form-control" autocomplete="off" placeholder="Database user name" required />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group clearfix mb-3">
                                       <div class="row">
                                          <label for="dbpassword" class=" col-md-3">Password</label>
                                          <div class=" col-md-9">
                                             <input id="dbpassword" type="password" value="" name="dbpassword" class="form-control" autocomplete="off" placeholder="Database user password" />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group clearfix mb-3">
                                       <div class="row">
                                          <label for="dbname" class=" col-md-3">Database Name</label>
                                          <div class=" col-md-9">
                                             <input id="dbname" type="text" value="" name="dbname" class="form-control" placeholder="Database Name" required />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group clearfix mb-5">
                                       <div class="row">
                                          <label for="dbprefix" class=" col-md-3">Database Prefix</label>
                                          <div class=" col-md-9">
                                             <input id="dbprefix" type="text" value="feedback_" name="dbprefix" class="form-control" placeholder="Database Prefix" maxlength="21" />
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="section clearfix">
                                 <p>3. Please enter your account details for administration.</p>
                                 <hr />
                                 <div>
                                    <div class="form-group clearfix mb-3">
                                       <div class="row">
                                          <label for="username" class=" col-md-3">Username</label>
                                          <div class="col-md-9">
                                             <input type="text" value=""  id="username"  name="username" class="form-control"  placeholder="Your Username" required />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group clearfix mb-3">
                                       <div class="row">
                                          <label for="email" class=" col-md-3">Email</label>
                                          <div class=" col-md-9">
                                             <input id="email" type="email" value="" name="email" class="form-control" placeholder="Your email" required />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group clearfix mb-5">
                                       <div class="row">
                                          <label for="password" class=" col-md-3">Password</label>
                                          <div class=" col-md-9">
                                             <input id="password" type="password" value="" name="password" class="form-control" placeholder="Login password" required />
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="section clearfix">
                                 <p>4. Please enter your item purchase code.</p>
                                 <hr />
                                 <div>
                                    <div class="form-group clearfix mb-5">
                                       <div class="row">
                                          <label for="purchase_code" class=" col-md-3">Item purchase code</label>
                                          <div class="col-md-9">
                                             <input type="text" value=""  id="purchase_code"  name="purchase_code" class="form-control"  placeholder="CodeCanyon License Number" required />
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class=" d-grid gap-2">
                                 <button type="submit" class="btn-square btn btn-primary btn-lg form-next" id="finished_button">
                                 <span class="waiting_text text-white" style="display: none;"><span> Please wait...</span></span>
                                 <span class="button-text text-white"><i data-feather="chevron-right" class='icon'></i> Finish</span> 
                                 </button>
                              </div>
                           </form>
                        </div>
						<br><br>
                        <div role="tabpanel" class="tab-pane" id="finished-tab">
                           <center>
						   <div class="section">
                              <div class="clearfix">
                                 <i data-feather="check-circle" height="2.5rem" width="2.5rem" stroke-width="3" class='status mr10'></i><span class="pull-left"  style="line-height: 50px;"> Congratulations! Idea Feedback Management System is now installed.</span>  
                              </div>
                              <div style="margin: 15px 0 15px 55px; color: #d73b3b;">
                                 Don't forget to delete the <b>/install</b> directory
                              </div>
                              <a class="go-to-login-page" href="<?php echo $dashboard_url; ?>">
                                 <div class="text-center">
                                    <div style="font-size: 100px;"><i data-feather="monitor" height="7rem" width="7rem" class="mb-2"></i></div>
                                    <div>GO TO YOUR LOGIN PAGE</div>
                                 </div>
                              </a>
                           </div>
						   </center>
						   <br><br>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-2"></div>
      </div>
   </body>
</html>
<script type="text/javascript">
   var onFormSubmit = function ($form) {       
       $form.find('[type="submit"]').find(".button-text").addClass("invisible");
       $('#finished_button').prop('disabled',true);
       $form.find('.waiting_text').css({
          display: '',          
       });
       $("#alert-container").html("");
   };
   var onSubmitSussess = function ($form) {        
       $form.find('[type="submit"]').find(".button-text").removeClass("invisible");
       $('#finished_button').prop('disabled',false)
       $form.find('.waiting_text').css({
          display: 'none',          
       });
   };
   
   feather.replace();
   
   $('#finished_button').prop('disabled',true);
   
   $('input').on('blur',function(){
       if($('#config-form')[0].checkValidity()==true){
           $('#finished_button').prop('disabled',false);            
       }
   })
   
   $(document).ready(function () {
       var $preInstallationTab = $("#pre-installation-tab"),
       $configurationTab = $("#configuration-tab");
   
       $(".form-next").click(function () {
           if ($preInstallationTab.hasClass("active")) {
               $preInstallationTab.removeClass("active");
               $configurationTab.addClass("active");
               $("#pre-installation").find("svg").remove();
               $("#pre-installation").prepend('<i data-feather="check-circle" class="icon"></i>');
               feather.replace();
               $("#configuration").addClass("active");
               $("#company_name").focus();
           }
       });
   
   
       jQuery.validator.addMethod("checkCode", function(value, element) {
           const regex = /^(\w{8})-((\w{4})-){3}(\w{12})$/gm;
           return regex.test(value);
       }, 'Please enter a valid purchase code.');
       $("#config-form").validate({
           errorClass: "is-invalid",
           validClass: "is-valid",
           errorElement: "div",
           errorPlacement: function(error, element) {
               $(error).addClass("invalid-feedback")
               error.appendTo( element.parent());
           }
       });
       $('input[name="purchase_code"]').rules('add', {
           checkCode: true
       });
       $("#config-form").submit(function () {
           var $form = $(this);
           if (!$form.valid()) {
               return false;
           }
           onFormSubmit($form);
           $form.ajaxSubmit({
               dataType: "json",
               success: function (result) {
                   onSubmitSussess($form, result);
                   if (result.success) {
                       $configurationTab.removeClass("active");
                       $("#configuration").find("svg").remove();
                       $("#configuration").prepend('<i data-feather="check-circle" class="icon"></i>');
                       $("#finished").find("svg").remove();
                       $("#finished").prepend('<i data-feather="check-circle" class="icon"></i>');
                       feather.replace();
                       $("#finished").addClass("active");
                       $("#finished-tab").addClass("active");
                   } else {
                       $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                       $("#company_name").focus();
                   }
               }
           });
           return false;
       });
   
   
       //lowercase 
       //21 max characers 
       //only a-z letter and underscore allowed
       $('#dbprefix').on('keyup', function () {
           var $dbPrefix = $('#dbprefix'),
           replacedValue = $dbPrefix.val().replace(/[^a-z_]/g, '');
   
           $dbPrefix.val(replacedValue);
       });
   
       //add an underscore at the end
       $('#dbprefix').on('blur', function () {
           var $dbPrefix = $('#dbprefix'),
           dbPrefixValue = $dbPrefix.val();
   
           //allow only 20 characters fo prefix since the last one will be an underscore
           dbPrefixValue = dbPrefixValue.substring(0, 20);
   
           //add underscore if not exists
           var lastChar = dbPrefixValue.substr(dbPrefixValue.length - 1);
           if (lastChar !== "_") {
               dbPrefixValue = dbPrefixValue + "_";
           }
   
           $dbPrefix.val(dbPrefixValue);
       });
   
   });
</script>