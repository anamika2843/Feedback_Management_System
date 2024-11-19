<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="col-12">
  <div class="card mb-4">
    <div class="card-header"><strong><?php echo app_lang('admin_feedback_title'); ?></strong></div>
    <div class="card-body">
      <?php echo form_open(route_to('admin/feedback/store')); ?>
      <div class="tab-content rounded-bottom">
        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-237">

        <div class="row">
          <div class="mb-3 col-12">
            <label class="form-label"><?php echo app_lang('admin_feedback_description'); ?></label>
            <input class="form-control <?php if (session('errors.feedback_description')) { ?>is-invalid<?php } ?>" type="text" name="feedback_description" placeholder="<?php echo app_lang('feedback_editdescription'); ?>" value="<?php echo old('feedback_description'); ?>">
            <div class="invalid-feedback">
                <?php echo session('errors.feedback_description'); ?>
              </div>
          </div>
          <div class="mb-3 col-4">
            <label class="form-label"><?php echo app_lang('admin_feedback_category'); ?></label>
            <select class=" form-select form-control-sm form-control <?php if (session('errors.category')) { ?>is-invalid<?php } ?>" name="category">
              <option value=""><?php echo app_lang('select_category'); ?></option>
             <?php foreach ($category as $value) { ?>
              <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
            <?php }?>
          </select>
          <div class="invalid-feedback">
                <?php echo session('errors.category'); ?>
              </div>
        </div>
        <div class="mb-3 col-4">
            <label class="form-label"><?php echo app_lang('admin_feedback_board'); ?></label>
            <select class="form-select form-control-sm form-control <?php if (session('errors.board_id')) { ?>is-invalid<?php } ?>" name="board_id">
              <option value=""><?php echo app_lang('select_board'); ?></option>
             <?php foreach ($boards as $value) { ?>
              <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
            <?php }?>
          </select>
          <div class="invalid-feedback">
                <?php echo session('errors.board_id'); ?>
              </div>
        </div>
        <div class="mb-3 col-4">
            <label class="form-label"><?php echo app_lang('admin_feedback_status'); ?></label>
            <select class="form-select form-control-sm form-control" name="status">
             <?php foreach ($status as $value) { ?>
              <option value="<?php echo $value->id; ?>"><?php echo $value->value; ?></option>
            <?php }?>
          </select>

        </div>
      </div>
    </div>
    <div class="p-3" >
      <button type="submit" class="mb-2 me-2 btn btn-shadow btn-primary" name="submit"><?php echo app_lang('save'); ?></button>
    </div>

  </div>
</form>
</div>
</div>
</div>
<?php echo $this->endSection(); ?>