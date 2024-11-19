<div class="app-header header-shadow">
    <div class="app-header__logo">
        <?php if (!empty($company_logo)) { ?>
            <img src="<?php echo base_url('public/uploads/company/'.$company_logo); ?>" alt="company_logo" class="img img-fluid logo-src">
        <?php } else { ?>
            <div class="widget-heading fsize-2"> <?php echo get_option('company_name'); ?></div>
        <?php } ?>
        <div class="header__pane ms-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    <div class="app-header__content">
        <div class="app-header-left">

        </div>
        <div class="app-header-right">
            <div class="header-dots">
            </div>

            <div class=" pe-5">
                <div class="widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <div class="profile-image"></div>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right outer-round">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-info br--4">
                                        <div class="menu-header-content text-start">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left me-3">
                                                        <div class="profile-image"></div>
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading"> <?php echo $current_user->username; ?></div>
                                                        <div class="widget-subheading opacity-8">  <?php echo $current_user->email; ?></div>
                                                    </div>
                                                   <div class="widget-content-right me-2">
                                                        <a href="<?php echo site_url('logout'); ?>" class="btn-pill btn-shadow btn-shine btn btn-focus"><?php echo app_lang('logout'); ?>

                                                    </a>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-btn-lg"></div>
                    <div class="widget-content-left header-user-info">
                        <div class="widget-heading"> <?php echo $current_user->username; ?></div>
                        <?php if (!empty($current_user_role)) { ?>
                            <div class="widget-subheading"><?php echo $current_user_role->name; ?></div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-btn-lg">
            <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
</div>
</div>
<?php echo $this->section('scripts'); ?>
<script>
    $(function(){
        "use strict";
        var username = '<?php echo $current_user->username; ?>'
        var intials = username.charAt(0);
        $('.profile-image').removeClass('hideme').text(intials);
    });
</script>
<?php echo $this->endSection(); ?>