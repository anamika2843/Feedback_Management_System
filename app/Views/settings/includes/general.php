<div class="tab-pane active card mb-4" id="emailSettings" role="tabpanel" aria-labelledby="GeneralSetting-tab">
    <div class="card-header">
        <?php echo $tab; ?>
    </div>
    <div class="card-body">
        <div class="tab-pane active preview" role="tabpanel" id="preview-438">
            <?php if (session()->has('errors')) { ?>
            <div class="alert alert-danger">
                <?php foreach (session('errors') as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="tab-pane mt-2 active preview">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="company_logo" data-toggle="tooltip" title="sd"><?php echo app_lang('setting_companylogo'); ?></label>
                        <input type="file" class="form-control" id="company_logo" name="company_logo" />
                        <?php if (!empty($company_logo)) { ?>
                            <div class="mt-3">
                                <a href="settings/remove_logo/company_logo"><i class="pe-7s-close f-30"></i></a>
                                <img src="<?php echo base_url('public/uploads/company/'.$company_logo); ?>" alt="company_logo" class="img img-fluid">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="favicon_logo"><?php echo app_lang('setting_favicon'); ?></label>
                    <input type="file" class="form-control" id="favicon_logo" name="favicon_logo" />
                    <?php if (!empty($favicon_logo)) { ?>
                            <div class="mt-3">
                                <a href="settings/remove_logo/favicon_logo"><i class="pe-7s-close f-30"></i></a>
                                <img src="<?php echo base_url('public/uploads/company/'.$favicon_logo); ?>" alt="favicon_logo" class="img img-fluid" >
                            </div>
                        <?php } ?>
                </div>

            </div>
        </div>
        <div class="mb-3 mt-2">
            <label for="company_name"><?php echo app_lang('setting_companyname'); ?></label>
            <input type="text" class="form-control" id="company_name" name="settings[company_name]" value="<?php echo get_option('company_name'); ?>" />
        </div>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="company_main_domain"><?php echo app_lang('setting_Companymaindomain'); ?></label>
                    <input type="text" class="form-control" id="company_main_domain" name="settings[comapny_main_domain]" value="<?php echo get_option('comapny_main_domain'); ?>" />
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="company_main_domain"><?php echo app_lang('setting_language'); ?></label>
                    <select name="settings[default_language]" id="settings[default_language]" class="form-control">
                        <?php foreach ($language_list as $key => $value) { ?>
                            <option value="<?php echo $key; ?>" <?php if (get_option('default_language') == $key) {
    echo 'selected';
}?>>
                                <?php echo $value; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="expiry_date"><?php echo app_lang('setting_expiry_date'); ?></label>
            <input type="text" class="form-control" id="expiry_date" name="settings[new_status_expiry_date]" value="<?php echo get_option('new_status_expiry_date'); ?>" />
        </div>

        <div class="mb-3">
           <input type="checkbox" data-toggle="toggle" name="settings[disable_copyright]" data-size="mini" value="yes" <?php if ('yes' == get_option('disable_copyright')) {
    echo 'checked';
}?>>
           <label  class="form-check-label" for="copyright_text"><?php echo app_lang('setting_disablecopyright'); ?></label>

       </div>
       <div class="mb-3">
           <input type="checkbox" data-toggle="toggle" name="settings[allow_guest_posting]" data-size="mini" value="yes" <?php if ('yes' == get_option('allow_guest_posting')) {
    echo 'checked';
}?>>
           <label  class="form-check-label" for="copyright_text"><?php echo app_lang('allow_guest_posting'); ?></label>

       </div>
       <div class="mb-3">
           <input type="checkbox" data-toggle="toggle" name="settings[allow_guest_commenting]" data-size="mini" value="yes" <?php if ('yes' == get_option('allow_guest_commenting')) {
    echo 'checked';
}?>>
           <label  class="form-check-label" for="allow_guest_commenting"><?php echo app_lang('allow_guest_commenting'); ?></label>

       </div>
   </div>
</div>
</div>
</div>