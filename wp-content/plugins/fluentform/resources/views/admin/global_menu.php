<?php
$page = sanitize_text_field($_GET['page']);
?>
<div class="ff_form_main_nav">
    <span class="plugin-name">
        <?php _e('Fluent Forms', 'fluentform'); ?> <?php if(defined('FLUENTFORMPRO')): ?>Pro<?php endif; ?>
    </span>
    <a href="<?php echo admin_url('admin.php?page=fluent_forms'); ?>" class="ninja-tab <?php echo ($page == 'fluent_forms') ? 'ninja-tab-active' : '' ?>">
        <?php _e('All Forms', 'fluentform'); ?>
    </a>
    <a href="<?php echo admin_url('admin.php?page=fluent_forms_all_entries');?>" class="ninja-tab <?php echo ($page == 'fluent_forms_all_entries') ? 'ninja-tab-active' : '' ?>">
        <?php _e('All Entries', 'fluentform'); ?>
    </a>

    <?php if($show_payment_entries): ?>
        <a href="<?php echo admin_url('admin.php?page=fluent_forms_payment_entries'); ?>" class="ninja-tab <?php echo ($page == 'fluent_forms_payment_entries') ? 'ninja-tab-active' : '' ?>">
            <?php _e('Payments', 'fluentform'); ?>
        </a>
    <?php endif; ?>

    <a href="<?php echo admin_url('admin.php?page=fluent_forms_settings'); ?>" class="ninja-tab <?php echo ($page == 'fluent_forms_settings') ? 'ninja-tab-active' : '' ?>">
        <?php _e('Global Settings', 'fluentform'); ?>
    </a>
    <a href="<?php echo admin_url('admin.php?page=fluent_forms_add_ons'); ?>" class="ninja-tab <?php echo ($page == 'fluent_forms_add_ons') ? 'ninja-tab-active' : '' ?>">
        <?php _e('Integrations', 'fluentform'); ?>
    </a>
    <?php if($show_payment): ?>
        <a href="<?php echo admin_url('admin.php?page=fluent_forms_settings&component=payment_settings'); ?>" class="ninja-tab">
            <?php _e('Payments', 'fluentform'); ?><span class="ff_new_badge">new</span>
        </a>
    <?php endif; ?>

    <?php if(!defined('FLUENT_MAIL') && !defined('FLUENTFORMPRO')): ?>
        <a class="ninja-tab <?php echo ($page == 'fluent_forms_smtp') ? 'ninja-tab-active' : '' ?>" href="<?php echo admin_url('admin.php?page=fluent_forms_smtp'); ?>">SMTP</a>
    <?php endif; ?>

    <a href="<?php echo admin_url('admin.php?page=fluent_forms_docs'); ?>" class="ninja-tab <?php echo ($page == 'fluent_forms_docs') ? 'ninja-tab-active' : '' ?>">
        <?php _e('Support', 'fluentform'); ?>
    </a>

    <?php do_action('fluentform_after_global_menu'); ?>
    <?php if(!defined('FLUENTFORMPRO')): ?>
        <a target="_blank" rel="noopener" href="<?php echo fluentform_upgrade_url(); ?>" class="ninja-tab buy_pro_tab">
            <?php _e('Upgrade to Pro', 'fluentform'); ?>
        </a>
    <?php endif; ?>
</div>
