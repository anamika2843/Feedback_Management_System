<div class="tab-pane active card mb-4" id="emailSettings" role="tabpanel" aria-labelledby="email-tab">
    <div class="card-header">

            <?php echo $tab; ?>
    </div>
    <div class="card-body">
        <p class="mb-4"><?php echo app_lang('recaptcha_description'); ?> <a href="https://www.google.com/recaptcha/" target="_blank"><?php echo app_lang('recaptcha_button_here'); ?></a></p>
        <div class="mb-3">
            <label class="form-label" for="site_key"><?php echo app_lang('recaptcha_sitekey'); ?></label>
            <input class= "form-control col-sm-12" type="text" name="settings[site_key]" id="site_key" value="<?php echo get_option('site_key'); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label" for="secret_key"><?php echo app_lang('recaptcha_secretkey'); ?></label>
            <input class= "form-control col-sm-12" type="text" name="settings[secret_key]" id="secret_key" value="<?php echo get_option('secret_key'); ?>">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="settings[enable_while_login]" id="while_login" <?php if ('yes' == get_option('enable_while_login')) {
    echo 'checked';
} ?> value="yes">
            <label class="form-check-label" for="while_login"><?php echo app_lang('recaptcha_login'); ?></label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="settings[enable_while_registration]"
            id="while_reg" <?php if ('yes' == get_option('enable_while_registration')) {
    echo 'checked';
} ?> value="yes">
            <label class="form-check-label" for="while_reg"><?php echo app_lang('recaptcha_registartion'); ?></label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="settings[enable_while_forgot_password]" id="while_forgot" <?php if ('yes' == get_option('enable_while_forgot_password')) {
    echo 'checked';
} ?> value="yes">
            <label class="form-check-label" for="while_forgot"><?php echo app_lang('recaptcha_password'); ?></label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="settings[enable_while_reset_password]" id="while_reset" <?php if ('yes' == get_option('enable_while_reset_password')) {
    echo 'checked';
} ?> value="yes">
            <label class="form-check-label" for="while_reset"><?php echo app_lang('recaptcha_reset'); ?></label>
        </div>
    </div>
</div>