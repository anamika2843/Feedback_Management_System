<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="col-12">
  <div class="card mb-4">
    <div class="card-header"><strong><?php echo app_lang('board_title'); ?></strong></div>
    <div class="card-body">
      <?php echo form_open(site_url('admin/boards/store'.(isset($board) ? '/'.$board->id : ''))); ?>

    <div class="tab-content rounded-bottom">
      <div class="tab-pane p-3 active preview" role="tabpanel">
        <div class="row">
          <div class="col-md-5">
            <label class="form-label"><?php echo app_lang('board_editname'); ?></label>
            <input class="form-control <?php if (session('errors.name')) { ?>is-invalid<?php } ?>" type="text" name="name" placeholder="<?php echo app_lang('board-name'); ?>" value="<?php echo $board->name ?? old('name'); ?>">
            <div class="invalid-feedback">
                <?php echo session('errors.name'); ?>
              </div>
          </div>
          <div class="col-md-7">
            <label class="form-label"><?php echo app_lang('board_editintrotxt'); ?></label>
            <input class="form-control <?php if (session('errors.intro_text')) { ?>is-invalid<?php } ?>" type="text" name="intro_text" placeholder="<?php echo app_lang('board-introtext'); ?>" value="<?php echo $board->intro_text ?? old('intro_text'); ?>">
            <div class="invalid-feedback">
                <?php echo session('errors.intro_text'); ?>
              </div>
          </div>
        </div>


      <div class="mt-3" >
        <button type="submit" class="mb-2 me-2 btn btn-shadow btn-primary" name="submit"><?php echo app_lang('board_editsave'); ?></button>
      </div>

    </div>
    <?php echo form_close(); ?>
  </div>
</div>
</div>
<?php echo $this->endSection(); ?>
