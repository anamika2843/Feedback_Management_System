<?php echo $this->extend('common/layout'); ?>
<?php echo $this->section('main'); ?>

<div class="h-100 bg-plum-plate bg-animation">
	<div class="d-flex h-100 justify-content-center align-items-center">
		<div class="mx-auto app-login-box col-md-6">
			<div class="app-header__logo app-logo-fms mx-auto mb-3">
			    <img src="<?= base_url('public/uploads/company')."/".get_option('company_logo'); ?>" alt="company_logo" class="logo-src">
			</div>
			<div class="modal-dialog w-100">
                <form action="<?php echo site_url('admin/forgot'); ?>" method="post">
                <?php echo csrf_field(); ?>
				<div class="modal-content">
					<div class="modal-header">
						<div class="h5 modal-title">
							<?php echo app_lang('forgot_your_password'); ?>?
							<h6 class="mt-1 mb-0 opacity-8">
								<p><?php echo lang('Auth.enterEmailForInstructions'); ?></p>
							</h6>
						</div>
					</div>
					<div class="modal-body">
						<div>
							<form class="">
								<div class="">
									<div class="col-md-12">
										<div class="position-relative mb-3">
											<label for="exampleEmail" class="form-label"><?php echo app_lang('forgot_email'); ?></label>
											<input name="email" id="exampleEmail"
											placeholder="Email here..." type="email" class="form-control <?php if (session('errors.email')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.email'); ?>">
											<div class="invalid-feedback">
											<?php echo session('errors.email'); ?>
										</div>
									</div>
									<?php
                                    if ('yes' == get_option('enable_while_forgot_password')) {
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
								</div>
							</form>
						</div>
						<div class="divider"></div>
						<h6 class="mb-0">
							<a href="<?php echo site_url('admin'); ?>" class="text-primary"><?php echo app_lang('signin_account'); ?></a>
						</h6>
					</div>
					<div class="modal-footer clearfix">
						<div class="float-end">
							<button class="btn btn-primary btn-lg"><?php echo app_lang('recover_password'); ?></button>
						</div>
					</div>
				</div>
			</form>
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
