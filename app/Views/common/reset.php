<?php echo $this->extend('common/layout'); ?>

<?php echo $this->section('title'); ?>
<?php echo lang('Auth.resetYourPassword'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('main'); ?>

<div class="h-100 bg-plum-plate bg-animation">
    <div class="d-flex h-100 justify-content-center align-items-center">
        <div class="mx-auto app-login-box col-md-8">
            <div class="app-header__logo app-logo-fms mx-auto mb-3">
                <img src="<?= base_url('public/uploads/company')."/".get_option('company_logo'); ?>" alt="company_logo" class="logo-src">
            </div>
            <div class="modal-dialog w-100">
                <form action="<?php echo site_url('admin/reset-password'); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5 class="modal-title">
                                <h4 class="mt-2">
                                    <p><?php echo lang('Auth.enterCodeEmailPassword'); ?></p>
                                </h4>
                            </h5>
                            <div class="divider row"></div>
                            <div class="">
                                <div class="col-md-12">
                                    <div class="position-relative mb-3">
                                     <input type="text" class="form-control <?php if (session('errors.token')) { ?>is-invalid<?php } ?>"
                                     name="token" placeholder="<?php echo lang('Auth.token'); ?>" value="<?php echo old('token', $token ?? ''); ?>">
                                     <div class="invalid-feedback">
                                        <?php echo session('errors.token'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative mb-3">
                                    <input type="email" class="form-control <?php if (session('errors.email')) { ?>is-invalid<?php } ?>"
                                    name="email" aria-describedby="emailHelp" placeholder="<?php echo lang('Auth.email'); ?>" value="<?php echo old('email'); ?>">
                                    <div class="invalid-feedback">
                                        <?php echo session('errors.email'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative mb-3">
                                    <input type="password" class="form-control <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" name="password" placeholder="Password">
                                    <div class="invalid-feedback">
                                        <?php echo session('errors.password'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative mb-3">
                                    <input type="password" class="form-control <?php if (session('errors.pass_confirm')) { ?>is-invalid<?php } ?>" name="pass_confirm" placeholder="Confirm Password">
                                    <div class="invalid-feedback">
                                        <?php echo session('errors.pass_confirm'); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    if ('yes' == get_option('enable_while_reset_password')) {
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
                    <div class="modal-footer d-block text-center">
                        <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg"><?php echo lang('Auth.resetPassword'); ?></button>
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
