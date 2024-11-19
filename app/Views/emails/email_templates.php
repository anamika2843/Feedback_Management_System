<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="row">
    <div class="col-sm-12">
      <div class="main-card mb-3 card">
        <div class="card-header">
            <div class="card-header-title font-size-lg text-capitalize fw-normal"><?php echo app_lang('email_templates'); ?>
            </div>
            <div class="btn-actions-pane-right">

            </div>
        </div>
        <div class="table-responsive">

        </div>
        <div class="d-block card-footer">
            <table class="table">
                <tbody>
                   <?php foreach ($template as $templates) {
    ?>
                    <tr>
                        <td>
                            <?php if (0 == $templates['active']) {
        ?>
                                <strike>
                                    <a href="email/template/<?php echo $templates['emailtemplateid']; ?>"><?php echo $templates['name']; ?></a><br>
                                    <small><?php echo $templates['slug']; ?></small>
                                </strike>
                                <?php
    } else {
        ?>
                                <a href="email/template/<?php echo $templates['emailtemplateid']; ?>"><?php echo $templates['name']; ?></a><br>
                                <small><?php echo $templates['slug']; ?></small>
                                <?php
    } ?>
                            <small class="pull-right">
                                <?php if ('1' == $templates['active']) {
        ?> <a href="email/template/disable/<?php echo $templates['emailtemplateid']; ?>"><?php echo app_lang('disable'); ?></a> <?php
    } else {
        ?><a href="email/template/enable/<?php echo $templates['emailtemplateid']; ?>"><?php echo app_lang('enable'); ?></a><?php
    } ?>
                        </small>
                    </td>
                </tr>
                <?php
}
            ?>
        </tbody>
    </table>
</div>
</div>

</div>
</div>
<?php echo $this->endSection(); ?>