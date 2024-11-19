<div class="tab-pane active card mb-4" id="emailSettings" role="tabpanel" aria-labelledby="email-tab">
    <div class="card-header">
        <?php echo $tab; ?>
    </div>
    <div class="card-body">

        <p><?php echo app_lang('email_protocol'); ?></p>

        <div class="tab-pane active" role="tabpanel" id="preview-438">
            <div class="form-check form-check-inline">
                <input class="form-check-input" id="smtp" type="radio" name="settings[email_protocol]" value="smtp"
                <?php if ('smtp' == $email_protocol) {
    echo 'checked';
} ?>>
                <label class="form-check-label" for="smtp"><?php echo app_lang('email-smtp'); ?> </label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" id="sendmail" type="radio" name="settings[email_protocol]"
                value="sendmail" <?php if ('sendmail' == $email_protocol) {
    echo 'checked';
} ?>>
                <label class="form-check-label" for="sendmail"><?php echo app_lang('email_sendmail'); ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" id="mail" type="radio" name="settings[email_protocol]" value="mail"
                <?php if ('mail' == $email_protocol) {
    echo 'checked';
} ?>>
                <label class="form-check-label" for="mail"><?php echo app_lang('email_mail'); ?></label>
            </div>
            <div class="tab-pane mt-2 active preview">
                <div class="row">
                    <div class="mb-3 smtp_host col-md-6 col-sm-6">
                        <label class="form-label"><?php echo app_lang('email_smtphost'); ?> </label>
                        <div class="tab-pane" role="tabpanel">
                            <input class="form-control" type="text" name="settings[smtp_host]"
                            value="<?php echo get_option('smtp_host'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 smtp_port col-md-3 col-sm-3" >
                        <label class="form-label"><?php echo app_lang('email_smtpport'); ?></label>
                        <div class="tab-pane" role="tabpanel">
                            <input class="form-control" type="text" name="settings[smtp_port]"
                            value="<?php echo get_option('smtp_port'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 smtp_encryption col-md-3 col-sm-3">
                        <label class="form-label"><?php echo app_lang('email_encryption'); ?></label>
                        <div class="tab-pane " role="tabpanel">
                            <select class="form-select" aria-label="Default select example"
                            name="settings[smtp_encryption]">
                            <option value="none" <?php if ('none' == $smtp_encryption) {
    echo 'selected';
} ?>
                            >None</option>
                            <option value="ssl" <?php if ('ssl' == $smtp_encryption) {
    echo 'selected';
} ?>>SSL
                            </option>
                            <option value="tls" <?php if ('tls' == $smtp_encryption) {
    echo 'selected';
} ?>>TLS
                            </option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="mb-3 col-md-6 col-sm-6 smtp_email">
                    <label class="form-label"><?php echo app_lang('email_smtpemail'); ?></label>
                    <div class="tab-pane " role="tabpanel">
                        <input class="form-control" type="text" name="settings[smtp_email]"
                        value="<?php echo get_option('smtp_email'); ?>">
                    </div>
                </div>
                <div class="mb-3 smtp_username col-md-6 col-sm-6">
                    <label class="form-label"><?php echo app_lang('email_smtpusername'); ?></label>
                    <div class="tab-pane " role="tabpanel">
                        <input class="form-control" type="text" name="settings[smtp_username]"
                        value="<?php echo get_option('smtp_username'); ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 smtp_password col-md-6 col-sm-6">
                    <label class="form-label smtp_password"><?php echo app_lang('email_smtppassword'); ?></label>
                    <div class="tab-pane " role="tabpanel">
                        <input class="form-control" type="password" name="settings[smtp_password]"
                        value="<?php echo decode_values(get_option('smtp_password'), 'smtp_pass'); ?>">
                    </div>
                </div>

                <div class="mb-3 col-md-6 col-sm-6">
                    <label class="form-label"><?php echo app_lang('email_charset'); ?></label>
                    <div class="tab-pane " role="tabpanel">
                        <input class="form-control" type="text" name="settings[smtp_email_charset]"
                        value="<?php echo get_option('smtp_email_charset') ?? ' utf-8'; ?>">
                    </div>
                </div>
            </div>
            <div class="mb-3 ">
                <label class="form-label"><?php echo app_lang('email_bcc'); ?></label>
                <div class="tab-pane " role="tabpanel">
                    <input class="form-control" type="text" name="settings[bcc_emails]"
                    value="<?php echo get_option('bcc_emails'); ?>">
                </div>
            </div>
            <div class="mb-3 ">
                <label class="form-label"><?php echo app_lang('reply_to'); ?></label>
                <div class="tab-pane " role="tabpanel">
                    <input class="form-control" type="text" name="settings[reply_to]"
                    value="<?php echo get_option('reply_to'); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php echo app_lang('email_signature'); ?></label>
                <div class="tab-pane " role="tabpanel">
                    <textarea rows="8" class="form-control"
                    name="settings[email_signature]"><?php echo get_option('email_signature'); ?></textarea>
                </div>
            </div>
            <hr class="mt-4">
            <div class="mb-3">
                <label class="form-label"><?php echo app_lang('email_predefinedheader'); ?></label>
                <div class="tab-pane " role="tabpanel">
                    <textarea rows="8"  class="form-control" name="settings[email_header]"><?php echo get_option('email_header'); ?></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php echo app_lang('email_predefinedfooter'); ?></label>
                <div class="tab-pane" role="tabpanel">
                    <textarea rows="8" class="form-control" name="settings[email_footer]"><?php echo get_option('email_footer'); ?></textarea>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <div class="form-group">
                    <div class="card-header-title font-size-lg text-capitalize fw-normal"><?php echo app_lang('email_sendtestmain'); ?></div>
                    <div class="page-title-subheading"><?php echo app_lang('email_sure'); ?></div>
                </div>
                <div class="form-group">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Your Email" name="test_email">
                    <button class="btn-hover-shine btn btn-primary send-test-email" type="button"><?php echo app_lang('email_send'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>