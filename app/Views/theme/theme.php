<?php echo $this->include('theme/partials/header'); ?>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <?php echo $this->include('theme/partials/topbar'); ?>
    <?php echo $this->include('theme/partials/right_sidebar.php'); ?>
    <div class="app-main">
        <?php echo $this->include('theme/partials/left_sidebar'); ?>
        <div class="app-main__outer">
            <div class="app-main__inner">
                <?php echo $this->include('theme/partials/breadcrumb'); ?>
                <?php echo $this->renderSection('content'); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->include('theme/partials/footer'); ?>
<?php echo $this->renderSection('modals'); ?>
<script>
    $('.open-right-drawer').on('click',function(){
        $('.app-drawer-wrapper').css('display','block')
    });
    $('.close_server_status_btn').on('click',function(){
       $('.app-drawer-wrapper').css('display','none')
    })
</script>