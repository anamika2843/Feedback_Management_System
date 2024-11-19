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

        <?php if (!$verified) { ?>
        <div class="mb-3 mt-2">
            <label for="settings[purchase_code]"><?php echo app_lang('purchase-code'); ?></label>
            <input type="text" class="form-control" id="settings[purchase_code]" name="settings[purchase_code]" value="<?php echo get_option('purchase_code'); ?>" />
        </div>
         <div class="mb-3 mt-2">
            <button class="btn btn-shadow btn-primary"><?php echo app_lang('save'); ?></button>
        </div>
        <?php } else { ?>
            <div class="alert alert-success">System installed and verified successfully!</div>
        <?php } ?>

   </div>
</div>
</div>
</div>