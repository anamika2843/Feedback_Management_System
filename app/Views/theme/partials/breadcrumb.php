<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <a href="<?php echo site_url('admin'); ?>">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit"></i>
                </a>
            </div>
            <div>
                <?php echo app_lang('dashboard'); ?>
                <div class="page-title-subheading">
                    <nav class="" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <?php foreach ($breadcrumb as $link => $value) { ?>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo route_to($link); ?>"><?php echo $value; ?></a>
                                </li>
                            <?php } ?>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</div>