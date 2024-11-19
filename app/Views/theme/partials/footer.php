 <div class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer__inner">
            <div class="app-footer-left">
                <span class="app-sidebar__footer"><a href="https://themesic.com/idea-feedback-management-system" alt="Feedback Management" target="_blank">Idea - Feedback management system</a></li>
            </div>
            <div class="app-footer-right">
                <?php echo $this->renderSection('footer_buttons'); ?>
            </div>
        </div>
    </div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/toastr.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/assets/main.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/dataTables.bootstrap4.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/dataTables.responsive.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/custom.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/highcharts/highcharts.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/highcharts/variable-pie.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/highcharts/export-data.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/highcharts/accessibility.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/highcharts/exporting.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/highcharts/highcharts-3d.js'); ?>"></script>
<script>
    "use strict";
    <?php $alertclass = '';
    $session          = session();
    if ($session->getFlashdata('message-success')) {
        $alertclass = 'success';
    } elseif ($session->getFlashdata('message-warning')) {
        $alertclass = 'warning';
    } elseif ($session->getFlashdata('message-info')) {
        $alertclass = 'info';
    } elseif ($session->getFlashdata('message-danger')) {
        $alertclass = 'danger';
    }
    if ($session->getFlashdata('message-'.$alertclass.'')) {
        $tempdata = $session->getFlashdata('message-'.$alertclass.'');
        ?>
        alert_float('<?php echo $alertclass; ?>',"<?php echo $tempdata['title']; ?>",'<?php echo $tempdata['message']; ?>');
        <?php
    }
    ?>

    tinymce.init({
      selector:'.editor',
      theme: 'modern',
      height: 200
    });

</script>
<?php echo $this->renderSection('scripts'); ?>
</body>

</html>