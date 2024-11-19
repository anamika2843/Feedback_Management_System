<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="col-12">
  <div class="card mb-4">
    <div class="card-header"><strong><?php echo app_lang('category_edit'); ?></strong></div>
    <div class="card-body">
      <?php echo form_open(site_url('admin/category/store'.(isset($category) ? '/'.$category->id : ''))); ?>

      <div class="tab-content rounded-bottom">
        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-237">
          <div class="mb-3">
            <label class="form-label"><?php echo app_lang('category_edittitle'); ?></label>
            <input class="form-control <?php if (session('errors.title')) { ?>is-invalid<?php } ?>" type="text" name="title" placeholder="<?php echo app_lang('category_title'); ?>" value="<?php echo $category->title ?? old('title'); ?>">
            <div class="invalid-feedback">
              <?php echo session('errors.title'); ?>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label"><?php echo app_lang('category_editdescription'); ?></label>
            <input class="form-control <?php if (session('errors.description')) { ?>is-invalid<?php } ?>" type="text" name="description" placeholder="<?php echo app_lang('category_description'); ?>" value="<?php echo $category->description ?? old('description'); ?>">
            <div class="invalid-feedback">
              <?php echo session('errors.description'); ?>
            </div>
          </div>
        </div>
        <div class="p-3" >
          <button type="submit" class="mb-2 me-2 btn btn-shadow btn-primary"><?php echo app_lang('category_editsave'); ?></button>
        </div>

      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<?php echo $this->endSection(); ?>