<?php echo $this->extend('common/layout'); ?>

<?php echo $this->section('title'); ?>
<?php echo lang('Auth.loginTitle'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('main'); ?>
<div class="h-100 bg-plum-plate bg-animation">
	<div class="d-flex h-100 justify-content-center align-items-center">
		<div class="mx-auto app-login-box col-md-8">
			<div class="app-header__logo app-logo-fms mx-auto mb-3">
			    <img src="<?= base_url('public/uploads/company')."/".get_option('company_logo'); ?>" alt="company_logo" class="logo-src">
			</div>
			<div class="modal-dialog w-100 mx-auto">
				<div class="modal-content">
					<form action="<?php echo site_url('admin/login'); ?>" method="post">
						<?php echo csrf_field(); ?>
						<div class="modal-body">
							<div class="h5 modal-title text-center">
								<h4 class="mt-2">
									<div><?php echo app_lang('welcome_back'); ?></div>
									<span><?php echo app_lang('login_msg'); ?></span>
								</h4>
							</div>
							<div class="">
								<div class="col-md-12">
									<div class="position-relative mb-3">
										<?php if ($config->validFields === ['email']) { ?>
											<input type="email" class="form-control <?php if (session('errors.login')) { ?>is-invalid<?php } ?>"
											name="login" placeholder="<?php echo lang('Auth.email'); ?>">
											<div class="invalid-feedback">
												<?php echo session('errors.login'); ?>
											</div>
										<?php } else { ?>
											<input type="text" class="form-control <?php if (session('errors.login')) { ?>is-invalid<?php } ?>"
											name="login" placeholder="<?php echo lang('Auth.emailOrUsername'); ?>">
											<div class="invalid-feedback">
												<?php echo session('errors.login'); ?>
											</div>
										<?php } ?>
									</div>
								</div>

								<div class="col-md-12">
									<div class="position-relative mb-3">
										<input type="password" name="password" class="form-control  <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.password'); ?>">
										<div class="invalid-feedback">
											<?php echo session('errors.password'); ?>
										</div>
									</div>
								</div>
								<?php
                                    if ('yes' == get_option('enable_while_login')) {
                                        ?>
										<div class="col-md-12">
											<div class="position-relative mb-3">
												<div class="g-recaptcha" data-sitekey="<?php echo get_option('site_key'); ?>"></div>
											</div>
										</div>
										<?php
                                    }
                                ?>
							</div>
							<div class="position-relative form-check mb-3">
								<input name="check" id="exampleCheck" type="checkbox" class="form-check-input">
								<label for="exampleCheck" class="form-label form-check-label"><?php echo app_lang('logged_in'); ?></label>
							</div>
						</div>
						<div class="modal-footer clearfix">
							<div class="float-start">
								<a href="<?php echo site_url('admin/forgot'); ?>" class="btn-lg btn btn-link"><?php echo app_lang('login_recover_password'); ?></a>
							</div>
							<div class="float-end">
								<button type="submit" class="btn btn-primary btn-lg"><?php echo app_lang('login_to_dashboard'); ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="text-center text-white opacity-8 mt-3"><?php if ('yes' == get_option('disable_copyright')) {
                                    echo '';
                                } else {
                                    echo get_option('copyright_text').'  ';
                                } ?></div>
		</div>
	</div>
</div>

<?php echo $this->endSection(); ?>
