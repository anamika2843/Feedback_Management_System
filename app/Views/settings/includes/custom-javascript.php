<div class="tab-pane active card mb-4" id="emailSettings" role="tabpanel" aria-labelledby="email-tab">
    <div class="card-header card-header-tab-animation">
        <ul class="nav nav-justified">
            <li class="nav-item">
                <a data-bs-toggle="tab" href="#tab-eg115-0" class="active nav-link"><?php echo app_lang('js_header'); ?></a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="tab" href="#tab-eg115-1" class="nav-link"><?php echo app_lang('js_footer'); ?></a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
           <div class="tab-pane active" id="tab-eg115-0" role="tabpanel">
               <div class="mb-3">
                <i class="fa fa-fw text-danger" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Please avoid script tag"></i>
                <label class="form-label" for="custom_js_header"><?php echo app_lang('js_header'); ?></label>
                <textarea rows="8" class= "form-control col-sm-12" type="text" name="settings[custom_js_header]" id="custom_js_header"><?php echo get_option('custom_js_header'); ?></textarea>
            </div>
        </div>
        <div class="tab-pane" id="tab-eg115-1" role="tabpanel">
           <div class="mb-3">
             <i class="fa fa-fw text-danger" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Please avoid script tag"></i>
              <label class="form-label" for="custom_js_footer"><?php echo app_lang('js_footer'); ?></label>
              <textarea rows="8" class= "form-control col-sm-12" type="text" name="settings[custom_js_footer]" id="custom_js_footer"><?php echo get_option('custom_js_footer'); ?></textarea>
          </div>
      </div>

  </div>
</div>