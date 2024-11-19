<div class="tab-pane active card mb-4" id="emailSettings" role="tabpanel" aria-labelledby="policy-tab">

    <div class="card-header card-header-tab-animation">
        <ul class="nav nav-justified">
            <li class="nav-item">
                <a data-bs-toggle="tab" href="#tab-eg115-0" class="active nav-link"><?php echo app_lang('policy_cookiearea'); ?></a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="tab" href="#tab-eg115-1" class="nav-link"><?php echo app_lang('policy_terms'); ?></a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="tab" href="#tab-eg115-2" class="nav-link"><?php echo app_lang('policy_privacy'); ?></a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-eg115-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="site_key"><?php echo app_lang('policy_cookiesnotice'); ?></label>
                        <input class= "form-control col-sm-12" type="text" name="settings[cookie_notice_text]" id="cookie_area" value="<?php echo get_option('cookie_notice_text'); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="site_key"><?php echo app_lang('policy_buttontxt'); ?></label>
                        <input class= "form-control col-sm-12" type="text" name="settings[cookie_area]" id="cookie_area" value="<?php echo get_option('cookie_area'); ?>">
                    </div>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="site_key"><?php echo app_lang('policy_cookielongtxt'); ?></label>
                  <textarea rows="8" class= "form-control col-sm-12" type="text" name="settings[cookie_longtext]" id="cookie_area"><?php echo get_option('cookie_longtext'); ?></textarea>
              </div>
          </div>

          <div class="tab-pane" id="tab-eg115-1" role="tabpanel">
            <div class="mb-3">
                <label class="form-label" for="site_key"><?php echo app_lang('policy_terms'); ?></label><br>
                <button type="button" class="btn me-2 mb-2  btn btn-shadow btn-primary" data-bs-toggle="modal" data-bs-target=".termsofusage"><?php echo app_lang('policy_pre'); ?></button>

                <textarea rows="8" class= "form-control col-sm-12 editor" type="text" name="settings[usage]" id="usage" ><?php echo $usage; ?></textarea>
            </div>
        </div>
        <div class="tab-pane" id="tab-eg115-2" role="tabpanel">
            <div class="mb-3">
                <label class="form-label" for="site_key"><?php echo app_lang('policy_privacy'); ?></label><br>
                <button type="button" class="btn me-2 mb-2  btn btn-shadow btn-primary" data-bs-toggle="modal" data-bs-target=".privacy_policy"><?php echo app_lang('policy_pre'); ?></button>
                <textarea rows="8" class= "form-control col-sm-12 editor" type="text" name="settings[privacy_policy]" id="privacy_policy" value=""><?php echo $privacy_policy; ?></textarea>
            </div>
        </div>

    </div>
</div>
<?php echo $this->section('modals'); ?>

<div class="modal fade termsofusage" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo app_lang('terms_of_usage'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <span><?php echo $usage; ?></span>
            </div>
            <div class="modal-footer">
                <button type="button" class=" btn btn-shadow btn-secondary" data-bs-dismiss="modal"><?php echo app_lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade privacy_policy" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo app_lang('policy_privacy'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <span><?php echo $privacy_policy; ?></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-shadow btn-secondary" data-bs-dismiss="modal"><?php echo app_lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>