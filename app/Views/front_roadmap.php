<!DOCTYPE html>
<?php $defaultLocale = service('request')->getLocale(); ?>
<html lang="<?php echo $defaultLocale; ?>">

<head>
	<title><?php echo app_lang('frontendtitle'); ?> - <?php echo $board_data->name ?? ''; ?> Roadmap - <?php echo app_lang('setting_companyname'); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="Keywords" content="">
	<meta name="description" content="<?php echo $board_data->intro_text ?>">
	<?php if (!empty(get_option('favicon_logo'))) { ?><link rel="icon" href="<?php echo base_url('public/uploads/company/' . get_option('favicon_logo')); ?>"><?php } ?>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/App.css'); ?>">
	<?php if (!empty(get_option('custom_js_header'))) { ?><script type="text/javascript">
		<?php echo get_option('custom_js_header'); ?>

	</script><?php } ?>

</head>

<body>
	<div id="root"></div>
	<script type="text/javascript">
		var base_url = "<?php echo base_url(); ?>";
		var board_data = <?php echo json_encode($board_data ?? []); ?>;
	</script>
	<?php if (!empty(get_option('custom_js_footer'))) { ?><script type="text/javascript">
		<?php echo get_option('custom_js_footer'); ?>

	</script><?php } ?>

	<script src="<?php echo base_url('assets/Roadmap.js'); ?>"></script>
</body>

</html>