 <div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
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
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
               <li class="app-sidebar__heading"><?php echo app_lang('menu'); ?></li>
               <li class="mm-active mm-collapse mm-show">
                <a href="#">
                    <i class="metismenu-icon pe-7s-rocket"></i>
                    <?php echo app_lang('overview'); ?>
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul class="<?php if ('dashboard' == $menu_item) {
    echo 'mm-collapse mm-show';
} ?>">
                    <li>
                        <a href="<?php echo site_url('/admin/home'); ?>" class="<?php if ('dashboard' == $menu_item) {
    echo 'mm-active';
} ?>">
                            <i class="metismenu-icon fa fa-fw icon-gradient swatch-holder-lg bg-asteroid" aria-hidden="true" ></i>
                            <?php echo app_lang('reports'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?php
            if (session()->get('logged_in') == has_permission('admin')) {
                ?>

                <li class="mm-active mm-collapse mm-show">
                    <a href="#">
                        <i class="metismenu-icon pe-7s-id"></i>
                        <?php echo app_lang('user_staff'); ?>
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul class="<?php if ('members' == $menu_item || 'users' == $menu_item) {
                    echo 'mm-collapse mm-show';
                } ?>">
                     <li>
                        <a href="<?php echo site_url('admin/members'); ?>" class="<?php if ('members' == $menu_item) {
                    echo 'mm-active';
                } ?>">
                            <i class="metismenu-icon fa fa-fw icon-gradient  bg-plum-plate" aria-hidden="true"></i>
                            <?php echo app_lang('staff_members'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/users'); ?>" class="<?php if ('users' == $menu_item) {
                    echo 'mm-active';
                } ?>">
                            <i class="metismenu-icon fa fa-fw icon-gradient bg-love-kiss" aria-hidden="true"></i>
                            <?php echo app_lang('users'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="mm-active mm-collapse mm-show">
                <a href="#">
                    <i class="metismenu-icon pe-7s-graph2"></i>
                    <?php echo app_lang('data'); ?>
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul class="<?php if ('category' == $menu_item || 'roadmap' == $menu_item || 'boards' == $menu_item || 'feedback' == $menu_item) {
                    echo 'mm-collapse mm-show';
                } ?>">
                 <li >
                    <a href="<?php echo site_url('admin/category'); ?>" class="<?php if ('category' == $menu_item) {
                    echo 'mm-active';
                } ?>">
                        <i class="metismenu-icon fa fa-fw icon-gradient bg-ripe-malin" aria-hidden="true"></i><?php echo app_lang('categories'); ?>
                    </a>
                </li>
                <li >
                    <a href="<?php echo site_url('admin/roadmap'); ?>" class="<?php if ('roadmap' == $menu_item) {
                    echo 'mm-active';
                } ?>">
                        <i class="metismenu-icon fa fa-fw icon-gradient swatch-holder-lg bg-happy-itmeo" aria-hidden="true" ></i><?php echo app_lang('road_map'); ?>
                    </a>
                </li>
                <li >
                    <a href="<?php echo site_url('admin/boards'); ?>" class="<?php if ('boards' == $menu_item) {
                    echo 'mm-active';
                } ?>">
                        <i class="metismenu-icon fa fa-fw icon-gradient bg-mixed-hopes" aria-hidden="true" ></i><?php echo app_lang('board'); ?>
                    </a>
                </li>
                <li class="<?php if ('comments' == $menu_item || 'feedback' == $menu_item) {echo 'mm-active';} ?>">
                    <a href="<?php echo site_url('admin/feedback'); ?>" class="<?php if ('feedback' == $menu_item) {
                        echo 'mm-active';} ?>">                                
                        <?php echo app_lang('feedback_items'); ?>
                    </a> 
                    <ul class="mm-show">
                        <li>
                            <a href="<?php echo site_url('admin/feedback/comments/'); ?>" class="<?php if ('comments' == $menu_item) {echo 'mm-active';} ?>">                                
                                <?php echo app_lang('feedback-all-comments'); ?>
                            </a>
                        </li>
                    </ul>
                </li>                
            </ul>
        </li>
        <li class="mm-active mm-collapse mm-show">
            <a href="#">
                <i class="metismenu-icon pe-7s-settings"></i>
                <?php echo app_lang('setting_menu'); ?>
                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>
            <ul class="<?php if ('email_templates' == $menu_item || 'settings' == $menu_item) {
                    echo 'mm-collapse mm-show';
                } ?>">

                <li>
                    <a href="<?php echo site_url('admin/email'); ?>" class="<?php if ('email_templates' == $menu_item) {
                    echo 'mm-active';
                } ?>">
                        <i class="metismenu-icon fa fa-fw icon-gradient bg-plum-plate" aria-hidden="true" ></i><?php echo app_lang('email-template'); ?>
                    </a>
                </li>

                <li>
                    <a href="<?php echo site_url('admin/settings'); ?>" class="<?php if ('settings' == $menu_item) {
                    echo 'mm-active';
                } ?>">
                     <i class="metismenu-icon fa fa-cog icon-gradient swatch-holder-lg bg-grow-early" aria-hidden="true"></i><?php echo app_lang('system_setting'); ?>
                 </a>
             </li>
         </ul>
     </li>
     <?php
            } else {
                ?>
    <li class="<?php if ('comments' == $menu_item || 'feedback' == $menu_item) {echo 'mm-active';} ?>">
                        <a href="<?php echo site_url('admin/feedback'); ?>" class="<?php if ('feedback' == $menu_item) {
                            echo 'mm-active';} ?>">                                
                            <?php echo app_lang('feedback_items'); ?>
                        </a> 
                        <ul class="mm-show">
                            <li>
                                <a href="<?php echo site_url('admin/feedback/comments/'); ?>" class="<?php if ('comments' == $menu_item) {echo 'mm-active';} ?>">                                
                                    <?php echo app_lang('feedback-all-comments'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
    <?php
            }
?>


</ul>
</div>
</div>
</div>