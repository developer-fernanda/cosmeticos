<?php

use FluentForm\App\Helpers\Helper;
?>
<?php do_action('fluentform_global_menu'); ?>
<h2><?php _e('Tools', 'fluentform'); ?></h2>

<div class="ff_form_wrap">
    <div class="ff_admin_menu_wrapper">
        <?php do_action('fluentform_before_export_import_wrapper'); ?>

        <div class="ff_admin_menu_sidebar">
            <ul class="ff_admin_menu_list">
                <li class="active">
                    <a data-hash="exportforms"
                       href="<?php echo Helper::makeMenuUrl('fluent_forms_transfer', ['hash' => 'exportforms']); ?>"
                    >
                        <?php echo __('Export Forms', 'fluentform'); ?>
                    </a>
                </li>
                <li>
                    <a data-hash="importforms"
                       href="<?php echo Helper::makeMenuUrl('fluent_forms_transfer', ['hash' => 'importforms']); ?>"
                    >
                        <?php echo __('Import Forms', 'fluentform'); ?>
                    </a>
                </li>
                <?php if ( ( new FluentForm\App\Services\Migrator\Bootstrap())->hasOtherForms()): ?>
                <li>
                    <a data-hash="migrator"
                       href="<?php echo Helper::makeMenuUrl('fluent_forms_transfer', ['hash' => 'migrator']); ?>"
                    >
                        <?php echo __('Migrator', 'fluentform'); ?>
                    </a>
                </li>
                <?php endif; ?>

                <li>
                    <a data-hash="activitylogs"
                       href="<?php echo Helper::makeMenuUrl('fluent_forms_transfer', ['hash' => 'activitylogs']); ?>"
                    >
                        <?php echo __('Activity Logs', 'fluentform'); ?>
                    </a>
                </li>
                <li>
                    <a data-hash="apilogs"
                       href="<?php echo Helper::makeMenuUrl('fluent_forms_transfer', ['hash' => 'apilogs']); ?>"
                    >
                        <?php echo __('API Logs', 'fluentform'); ?>
                    </a>
                </li>
            </ul>
        </div>

        <div class="ff_admin_menu_container">
            <?php do_action('fluentform_before_export_import_container'); ?>
            <div class="ff_transfer" id="ff_transfer_app">
                <component :is="component" :app="App"></component>
            </div>
            <?php do_action('fluentform_after_before_export_import_container'); ?>
        </div>

        <?php do_action('fluentform_after_export_import_wrapper'); ?>
    </div>
</div>
