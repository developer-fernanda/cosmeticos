<?php

/**
 * Add all ajax hooks
 */

use FluentForm\App\Modules\Acl\Acl;

/**
 * @var $app \FluentForm\Framework\Foundation\Application
 */

$app->addPublicAjaxAction('fluentform_submit', function () use ($app) {
    (new \FluentForm\App\Modules\Form\FormHandler($app))->onSubmit();
});

$app->addAdminAjaxAction('fluentform_submit', function () use ($app) {
    (new \FluentForm\App\Modules\Form\FormHandler($app))->onSubmit();
});

$app->addAdminAjaxAction('fluentform-global-settings', function () use ($app) {
    Acl::verify('fluentform_settings_manager');
    (new \FluentForm\App\Modules\Settings\Settings($app->request))->get();
});

$app->addAdminAjaxAction('fluentform-global-settings-store', function () use ($app) {
    Acl::verify('fluentform_settings_manager');
    (new \FluentForm\App\Modules\Settings\Settings($app->request))->store();
});

$app->addAdminAjaxAction('fluentform-forms', function () use ($app) {
    Acl::verify('fluentform_dashboard_access');
    (new \FluentForm\App\Modules\Form\Form($app))->index();
});

$app->addAdminAjaxAction('fluentform-form-store', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Form($app))->store();
});

$app->addAdminAjaxAction('fluentform-form-find', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Form($app))->find();
});

$app->addAdminAjaxAction('fluentform-form-update', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Form($app))->update();
});

$app->addAdminAjaxAction('fluentform-form-delete', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Form($app))->delete();
});

$app->addAdminAjaxAction('fluentform-form-duplicate', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Form($app))->duplicate();
});

$app->addAdminAjaxAction('fluentform_get_all_entries', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->getAllFormEntries();
});

$app->addAdminAjaxAction('fluentform_get_all_entries_report', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->getEntriesReport();
});

$app->addAdminAjaxAction('fluentform-form-inputs', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Inputs($app))->index();
});

$app->addAdminAjaxAction('fluentform-load-editor-shortcodes', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Component\Component($app))->getEditorShortcodes();
});

$app->addAdminAjaxAction('fluentform-load-all-editor-shortcodes', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Component\Component($app))->getAllEditorShortcodes();
});

$app->addAdminAjaxAction('fluentform-settings-formSettings', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\FormSettings($app))->index();
});

$app->addAdminAjaxAction('fluentform-settings-general-formSettings', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\FormSettings($app))->getGeneralSettingsAjax();
});

$app->addAdminAjaxAction('fluentform-save-settings-general-formSettings', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\FormSettings($app))->saveGeneralSettingsAjax();
});

$app->addAdminAjaxAction('fluentform-settings-formSettings-store', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\FormSettings($app))->store();
});

$app->addAdminAjaxAction('fluentform-settings-formSettings-remove', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\FormSettings($app))->remove();
});

$app->addAdminAjaxAction('fluentform-get-form-custom_css_js', function () {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\FormCssJs)->getSettingsAjax();
});

$app->addAdminAjaxAction('fluentform-save-form-custom_css_js', function () {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\FormCssJs)->saveSettingsAjax();
});

$app->addAdminAjaxAction('fluentform-save-form-entry_column_view_settings', function () {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\EntryColumnViewSettings)->saveVisibleColumnsAjax();
});

$app->addAdminAjaxAction('fluentform-save-form-entry_column_order_settings', function () {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\EntryColumnViewSettings)->saveEntryColumnsOrderAjax();
});

$app->addAdminAjaxAction('fluentform-reset-form-entry_column_order_settings', function () {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Settings\EntryColumnViewSettings)->resetEntryDisplaySettings();
});

$app->addAdminAjaxAction('fluentform-load-editor-components', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Component\Component($app))->index();
});

$app->addAdminAjaxAction('fluentform-form-entry-counts', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->getEntriesGroup();
});

$app->addAdminAjaxAction('fluentform-form-entries', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->getEntries();
});

$app->addAdminAjaxAction('fluentform-form-report', function () use ($app) {
    $formId = intval($_REQUEST['form_id']);
    Acl::verify('fluentform_entries_viewer', $formId);
    (new \FluentForm\App\Modules\Entries\Report($app))->getReport($formId);
});

$app->addAdminAjaxAction('fluentform-form-entries-export', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Export($app))->index();
});

$app->addAdminAjaxAction('fluentform-get-entry', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->getEntry();
});

$app->addAdminAjaxAction('fluentform-update-entry-user', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->changeEntryUser();
});

$app->addAdminAjaxAction('fluentform-get-users', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->getUsers();
});


$app->addAdminAjaxAction('fluentform-get-entry-notes', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->getNotes();
});

$app->addAdminAjaxAction('fluentform-add-entry-note', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->addNote();
});

$app->addAdminAjaxAction('fluentform-get-entry-logs', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    $entry_id = intval($_REQUEST['entry_id']);
    $logType = sanitize_text_field($_REQUEST['log_type']);
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->getLogsByEntry($entry_id, $logType);
});

$app->addAdminAjaxAction('fluentform_get_activity_log_filters', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->getLogFilters();
});

$app->addAdminAjaxAction('fluentform_get_activity_api_log_filters', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->getApiLogFilters();
});

$app->addAdminAjaxAction('fluentform_get_all_logs', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->getAllLogs();
});

$app->addAdminAjaxAction('fluentform_get_api_logs', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->getApiLogs();
});

$app->addAdminAjaxAction('fluentform_retry_api_action', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->retryApiAction();
});

$app->addAdminAjaxAction('fluentform_delete_logs_by_ids', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->deleteLogsByIds();
});

$app->addAdminAjaxAction('fluentform_delete_api_logs_by_ids', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Logger\DataLogger($app))->deleteApiLogsByIds();
});

$app->addAdminAjaxAction('fluentform-reset-analytics', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Form\Analytics($app))->resetFormAnalytics();
});


$app->addAdminAjaxAction('fluentform-change-entry-status', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->changeEntryStatus();
});

$app->addAdminAjaxAction('fluentform-delete-entry', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->deleteEntry();
});

$app->addAdminAjaxAction('fluentform-change-entry-favorites', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->favoriteChange();
});

$app->addAdminAjaxAction('fluentform-do_entry_bulk_actions', function () use ($app) {
    Acl::verify('fluentform_entries_viewer');
    (new \FluentForm\App\Modules\Entries\Entries())->handleBulkAction();
});

$app->addAdminAjaxAction('fluentform-get-extra-form-settings', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new FluentForm\App\Modules\Form\Settings\ExtraSettings($app))->getExtraSettingNavs();
});

$app->addAdminAjaxAction('fluentform-get-form-settings-extra-component', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new FluentForm\App\Modules\Form\Settings\ExtraSettings($app))->getExtraSettingsComponent();
});

$app->addAdminAjaxAction(
    'fluentform-get-pages',
    function () {
        Acl::verify('fluentform_forms_manager');

        $pages = get_pages();
        $formattedPages = [];

        foreach ($pages as $index => $page) {
            $formattedPages[] = [
                'ID'         => $page->ID,
                'post_title' => $page->post_title,
                'guid'       => $page->guid
            ];
        }

        wp_send_json_success([
            'pages' => $formattedPages
        ], 200);
    }
);


$app->addAdminAjaxAction('fluentform_notice_action_track_yes', function () use ($app) {
    Acl::hasAnyFormPermission();
    (new FluentForm\App\Modules\Track\TrackModule())->sendInitialInfo();
});

$app->addAdminAjaxAction('fluentform_install_fluentsmtp', function () {
    Acl::hasAnyFormPermission();
    (new FluentForm\App\Modules\Track\SetupModule())->installPlugin('fluent-smtp');
});

// Export forms
$app->addAdminAjaxAction('fluentform-export-forms', function () use ($app) {
    Acl::verify('fluentform_settings_manager');
    (new \FluentForm\App\Modules\Form\Transfer($app))->export();
});

// Import forms
$app->addAdminAjaxAction('fluentform-import-forms', function () use ($app) {
    Acl::verify('fluentform_settings_manager');
    (new \FluentForm\App\Modules\Form\Transfer($app))->import();
});

$app->addAdminAjaxAction('fluentform-get-all-forms', function () use ($app) {
    Acl::verify(['fluentform_settings_manager', 'fluentform_forms_manager']);
    (new \FluentForm\App\Modules\Form\Form($app))->getAllForms();
});

// Fetch simplified information for all predefined forms
$app->addAdminAjaxAction('fluentform-predefined-forms', function () use ($app) {
    Acl::hasAnyFormPermission();
    (new \FluentForm\App\Modules\Form\Predefined($app))->all();
});

// Create a form by predefined data
$app->addAdminAjaxAction('fluentform-predefined-create', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    (new \FluentForm\App\Modules\Form\Predefined($app))->create();
});

/**
 * Add fluentform_submission_inserted actions for
 * slack and mailchimp if the form was submitted.
 */


// Permission settings
$app->addAdminAjaxAction('fluentform_get_access_roles', function () {
    Acl::verify('fluentform_full_access');
    $roleManager = new \FluentForm\App\Modules\Acl\RoleManager();
    $roleManager->getRoles();
});

$app->addAdminAjaxAction('fluentform_set_access_roles', function () {
    Acl::verify('fluentform_full_access');
    $roleManager = new \FluentForm\App\Modules\Acl\RoleManager();
    $roleManager->setRoles();
});


// General Integration Settings Here
$app->addAdminAjaxAction('fluentform_get_global_integration_settings', function () use ($app) {
    Acl::verify('fluentform_settings_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->getGlobalSettingsAjax();
});

$app->addAdminAjaxAction('fluentform_post_global_integration_settings', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->saveGlobalSettingsAjax();
});

$app->addAdminAjaxAction('fluentform_get_all-general-integration-feeds', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->getAllFormIntegrations();
});

$app->addAdminAjaxAction('fluentform_post_update_form_integration_status', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->updateNotificationStatus();
});

$app->addAdminAjaxAction('fluentform_get_form_integration_settings', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->getIntegrationSettings();
});
$app->addAdminAjaxAction('fluentform_post_form_integration_settings', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->saveIntegrationSettings();
});
$app->addAdminAjaxAction('fluentform-delete-general_integration_feed', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->deleteIntegrationFeed();
});

$app->addAdminAjaxAction('fluentform_get_form_integration_list', function () use ($app) {
    Acl::verify('fluentform_forms_manager');
    $globalIntegrationManager = new \FluentForm\App\Services\Integrations\GlobalIntegrationManager($app);
    $globalIntegrationManager->getIntegrationList();
});

$app->addAdminAjaxAction('fluentform_update_modules', function () {
    Acl::verify('fluentform_settings_manager');
    return (new \FluentForm\App\Modules\AddOnModule())->updateAddOnsStatus();
});


/*
 * Background Process Receiver
 */

$app->addAdminAjaxAction('fluentform_background_process', function () {
    $this->app['fluentFormAsyncRequest']->handleBackgroundCall();
});

$app->addPublicAjaxAction('fluentform_background_process', function () {
    $this->app['fluentFormAsyncRequest']->handleBackgroundCall();
});

