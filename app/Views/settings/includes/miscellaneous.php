<div class="tab-pane active card mb-4" id="emailSettings" role="tabpanel" aria-labelledby="email-tab">
    <div class="card-header">
        <?php echo $tab; ?>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <label class="form-label">
                <i class="fa fa-question-circle pull-left" data-bs-toggle="tooltip" data-bs-placement="right" title="Tables with large amount of data will have horizontal scroll instead rows wrapped in + icon."></i>
                <?php echo app_lang('mis_table'); ?>
            </label>
            <div class="form-check">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="settings[res_table]" checked id="res_table_yes" value="yes" <?php if ('yes' == get_option('res_table')) {
    echo 'checked';
} ?> >
                    <label class="form-check-label" for="res_table_yes"><?php echo app_lang('mis_yes'); ?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="settings[res_table]" id="res_table_no" <?php if ('no' == get_option('res_table')) {
    echo 'checked';
} ?> value="no" >
                    <label class="form-check-label" for="res_table_no"><?php echo app_lang('mis_no'); ?></label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <label class="form-label">
                <i class="fa fa-question-circle pull-left" data-bs-toggle="tooltip" data-bs-placement="right" title="Tables Pagination Limit"></i>
                <?php echo app_lang('mis_limit'); ?>
            </label>
            <div class="form-check">
               <input type="text" name="settings[tables_pagination_limit]" class="form-control" id="pagination_limit" value="<?php echo get_option('tables_pagination_limit'); ?>">
               <label class="form-label" for="pagination_limit"></label>
            </div>
        </div>
    </div>
</div>