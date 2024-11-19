<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<?php echo form_open(route_to('admin/email/template/update')); ?>
<div class="row">
  <div class="col-sm-7">
    <div class="card mb-4">

      <div class="card-header position-relative d-flex justify-content-center align-items-center">
        <?php echo $template['name']; ?>
      </div>
      <div class="card-body row ">
        <div class="tab-pane  active preview">
          <div class="mb-3">
            <label class="form-label">Template Title</label>
            <input class="form-control" type="text" placeholder="" value="<?php echo $template['name']; ?>" Disabled name="name">
          </div>
        </div>
        <div class="tab-pane active preview">
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input class="form-control" type="text" value="<?php echo $template['subject']; ?>" name="subject">
          </div>
        </div>
        <div class="tab-pane  active preview">
          <div class="mb-3">
            <label class="form-label">From Name</label>
            <input class="form-control" type="text" placeholder="" value="<?php echo $template['fromname']; ?>" name="fromname">
          </div>
        </div>
        <div class="tab-pane mb-5 active preview">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="active" id="active_input" <?php if (0 == $template['active']) {
    echo 'checked';
} ?>>
            <label class="form-check-label" for="active_input">Disabled</label>
          </div>
        </div>
        <div class="tab-pane  active preview">
          <div class="mb-3">
            <textarea class='editor' name='message'><?php echo $template['message']; ?></textarea>
          </div>
        </div>
        <input type="hidden" name="emialtemplateid" value="<?php echo $template['emailtemplateid']; ?>">
      </div>
    </div>
  </div>
  <div class="col-sm-5">
    <div class="card mb-4">

      <div class="card-header position-relative d-flex justify-content-center align-items-center">
        Available Merge Fields
      </div>
      <div class="card-body row ">
        <div class="tab-pane  active preview">
          <table>
          <?php foreach ($merge_fields as $key => $value) { ?>
            <tr>
              <td class="col-md-2"><?php echo ucwords(strtolower(str_replace("_"," ",$value))); ?></td>
              <td  class="col-md-2"><a href="#" class="add_merge_field"><?php echo '{'.$value.'}'; ?></a></td>
            </tr>
          <?php } ?>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="float-end p-3">
  <input type="submit" name="" class="mb-2 me-2 btn btn-shadow btn-success" value="SAVE">
</div>
</form>
<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
  <script>
    "use strict";
    $('.add_merge_field').on('click', function(event) {
      event.preventDefault();
      tinymce.activeEditor.execCommand('mceInsertContent', false, $(this).text());
    });
  </script>
<?php echo $this->endsection(); ?>
