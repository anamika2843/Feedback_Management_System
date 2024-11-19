<!doctype html>
<?php $defaultLocale = service('request')->getLocale(); ?>
<html lang="<?php echo $defaultLocale; ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title; ?> - <?php echo app_lang('setting_companyname'); ?></title>
    <?php echo csrf_meta(); ?>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="">


    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <?php if (!empty($favicon_logo)) { ?>
        <link rel="icon" href="<?php echo base_url('public/uploads/company/'.$favicon_logo); ?>">
    <?php } ?>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/main.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/scripts/responsive.dataTables.min.css'); ?>">
    <style type="text/css">
        .mce-flow-layout-item.mce-last{display: none !important;}
        .app-sidebar__footer { z-index: 9 }
    </style>
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.6.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
    <script>tinymce.init({
        selector:'editor',
        });</script>
    <script type="text/javascript">
        "use strict";
        var base_url = "<?php echo base_url(); ?>";
        var site_url = "<?php echo site_url(); ?>";
        var csrfName = '<?php echo csrf_token(); ?>';
        var csrfHash = '<?php echo csrf_hash(); ?>';
        var responsive_table = "<?php echo 'yes' == get_option('res_table') ? true : false; ?>";
        var length_options = [10,25,50,100];
        var length_options_names = [10,25,50,100];
        var default_length = "<?php echo !empty(get_option('tables_pagination_limit')) ? get_option('tables_pagination_limit') : 25; ?>";
        if ($.inArray(<?php echo !empty(get_option('tables_pagination_limit')) ? get_option('tables_pagination_limit') : 10; ?>, length_options) == -1) {
            length_options.push(<?php echo get_option('tables_pagination_limit'); ?>);
            length_options_names.push(<?php echo get_option('tables_pagination_limit'); ?>);
        }
    </script>
</head>

<body>
