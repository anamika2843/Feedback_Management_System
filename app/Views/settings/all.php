<?php echo $this->extend('theme/theme'); ?>

<?php echo $this->section('content'); ?>
<div class="row">
	<div class="col-sm-4">
		<div class="card ">
			<ul class="list-group">
					<?php foreach ($left_side_tabs as $key => $value) { ?>
						<a href="<?php echo route_to('settings').'?group='.$value; ?>" class="list-group-item-action list-group-item <?php if ($value == $tab) {
    echo ' active ';
} ?>">
							<?php echo ucwords(app_lang($value)); ?>
						</a>
					<?php } ?>
			</ul>
		</div>
	</div>
	<div class="col-sm-8 ">
		<?php echo form_open_multipart(route_to('admin/settings/save').'?group='.$tab); ?>
		<div class="tab-content">
			<?php echo $this->include('settings/includes/'.$tab); ?>
		</div>
		<?php echo $this->section('footer_buttons'); ?>
		<button class="mb-2 me-2 btn btn-shadow btn-primary" id="btn_setting" type="submit"><?php echo app_lang('setting_submit'); ?></button>
		<?php echo form_close(); ?>
		<?php echo $this->endSection(); ?>
	</div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<script>
	"use strict";
	$(function(){
		var email_protocol = "<?php echo get_option('email_protocol'); ?>";
		if(email_protocol=="mail"){
			$('.smtp_encryption').hide();
			$('.smtp_host').hide();
			$('.smtp_port').hide();
			$('.smtp_username').hide();
			$('.smtp_password').hide();
		}
		$('input[name="settings[email_protocol]"]').on('change',function(){
			var val = $(this).val();
			if(val=="mail"){
				$('.smtp_encryption').hide();
				$('.smtp_host').hide();
				$('.smtp_port').hide();
				$('.smtp_username').hide();
				$('.smtp_password').hide();
			}else{
				$('.smtp_encryption').show();
				$('.smtp_host').show();
				$('.smtp_port').show();
				$('.smtp_username').show();
				$('.smtp_password').show();
				$('.smtp_email').show();
			}
		});
		$(".send-test-email").on('click',function(){
			var email = $('input[name="test_email"]').val();
			if(email!=""){
				$.ajax({
					url: site_url+'/admin/send_test_email',
					type: 'POST',
					dataType: 'json',
					data: {email:email,[csrfName]:csrfHash},
				})
				.done(function(response) {
					if(response.success==false){
						alert_float('error',"<?php echo app_lang('test_email'); ?>",response.message)
					}else{
						alert_float('success',"<?php echo app_lang('test_email'); ?>",response.message)
					}
				});
			}else{
				alert_float('info',"<?php echo app_lang('test_email'); ?>",'<?php echo app_lang('email_required'); ?>');
			}

		})
	})
</script>

<?php echo $this->endSection(); ?>