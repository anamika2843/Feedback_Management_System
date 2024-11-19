<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $this->renderSection('title'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
        <meta name="description" content="">
        <!-- Disable tap highlight on IE -->
        <meta name="msapplication-tap-highlight" content="no">
       <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/main.css'); ?>">
       <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom.css'); ?>">
        <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.6.0.min.js'); ?>"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <?php echo $this->renderSection('pageStyles'); ?>
    </head>
    <body>
        <div class="float-alert">

        </div>
     <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
             <?php echo $this->renderSection('main'); ?>
        </div>
 </div>
 <?php echo $this->renderSection('pageScripts'); ?>
 <script type="text/javascript" src="<?php echo base_url('assets/main.js'); ?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/scripts/toastr.js'); ?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/scripts/custom.js'); ?>"></script>
 <script>
        <?php $alertclass = '';
            $session      = session();
            if ($session->getFlashdata('message-success')) {
                $alertclass = 'success';
            } elseif ($session->getFlashdata('message-warning')) {
                $alertclass = 'warning';
            } elseif ($session->getFlashdata('message-info')) {
                $alertclass = 'info';
            } elseif ($session->getFlashdata('message-danger')) {
                $alertclass = 'danger';
            }
              if ($session->getFlashdata('message-'.$alertclass.'')) {
                  $tempdata = $session->getFlashdata('message-'.$alertclass.'');
                ?>
                  alert_float('<?php echo $alertclass; ?>',"<?php echo $tempdata['title']; ?>",'<?php echo $tempdata['message']; ?>');
                <?php
              }
         ?>


 </script>
</body>
</html>
