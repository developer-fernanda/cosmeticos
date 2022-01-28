<?php

namespace FluentForm\App\Modules\Registerer;

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Activator;
use FluentForm\App\Modules\AddOnModule;
use FluentForm\App\Modules\DocumentationModule;
use FluentForm\Framework\Foundation\Application;
use FluentForm\View;

class Menu
{
    /**
     * @var \FluentForm\Framework\Foundation\Application
     */
    protected $app;

    /**
     * Menu constructor.
     *
     * @param \FluentForm\Framework\Foundation\Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;

        $this->app->addFilter('fluentform_form_settings_menu', array(
            $this, 'filterFormSettingsMenu'
        ), 10, 2);
    }

    public function reisterScripts()
    {
        if (!$this->isFluentPages()) {
            return;
        }

        $app = $this->app;

        wp_register_script(
        	'fluent_forms_global',
	        $app->publicUrl('js/fluent_forms_global.js'),
	        array('jquery'),
	        FLUENTFORM_VERSION,
	        true
        );

        wp_register_style(
            'fluentform_settings_global',
            $app->publicUrl("css/settings_global.css"),
            array(),
            FLUENTFORM_VERSION,
            'all'
        );

        wp_register_script(
            'clipboard',
            $app->publicUrl('libs/clipboard.min.js'),
            array(),
            false,
            true
        );

        wp_register_script(
            'copier',
            $app->publicUrl('js/copier.js'),
            array(),
            false,
            true
        );

        wp_register_script(
            'fluentform_form_settings',
            $app->publicUrl("js/form_settings_app.js"),
            array('jquery'),
            FLUENTFORM_VERSION,
            true
        );

        wp_register_script(
            'fluent_all_forms',
            $app->publicUrl("js/fluent-all-forms-admin.js"),
            array('jquery'),
            FLUENTFORM_VERSION,
            true
        );

        wp_register_style(
            'fluent_all_forms',
            $app->publicUrl("css/fluent-all-forms.css"),
            array(),
            FLUENTFORM_VERSION,
            'all'
        );

        wp_register_script(
            'fluentform_editor_script',
            $app->publicUrl("js/fluent-forms-editor.js"),
            array('jquery'),
            FLUENTFORM_VERSION,
            true
        );

        wp_register_style(
            'fluentform_editor_style',
            $app->publicUrl("css/fluent-forms-admin-sass.css"),
            [],
            FLUENTFORM_VERSION,
            'all'
        );

        wp_register_style(
            'fluentform_editor_sass',
            $app->publicUrl("css/fluent-forms-admin.css"),
            [],
            FLUENTFORM_VERSION,
            'all'
        );

        wp_register_script(
            'fluentform-transfer-js',
            $app->publicUrl("js/fluentform-transfer.js"),
            ['jquery'],
            FLUENTFORM_VERSION,
            true
        );

        wp_register_script(
            'fluentform-global-settings-js',
            $app->publicUrl("js/fluentform-global-settings.js"),
            ['jquery'],
            FLUENTFORM_VERSION,
            true
        );

        wp_register_script(
            'fluentform-modules',
            $app->publicUrl('js/modules.js'),
            ['jquery'],
            FLUENTFORM_VERSION,
            true
        );

        wp_register_script(
            'fluentform_form_entries',
            $app->publicUrl('js/form_entries.js'),
            array('jquery'),
            FLUENTFORM_VERSION,
            true
        );

        wp_register_script(
            'fluentform_all_entries',
            $app->publicUrl('js/all_entries.js'),
            array('jquery'),
            FLUENTFORM_VERSION,
            true
        );

        wp_register_style(
            'fluentform-add-ons',
            $app->publicUrl('css/add-ons.css'),
            [],
            FLUENTFORM_VERSION,
            'all'
        );

        wp_register_style(
            'fluentform_doc_style',
            $app->publicUrl('css/admin_docs.css'),
            [],
            FLUENTFORM_VERSION,
            'all'
        );

        add_filter('admin_footer_text', function ($text) {
            return '<span id="footer-thankyou">Thanks for using <a target="_blank" rel="nofollow" href="https://wordpress.org/plugins/fluentform">Fluent Forms</a>.</span>';
        });

        wp_enqueue_style('fluentform_global_elements', $app->publicUrl('css/element-ui-css.css'), [], FLUENTFORM_VERSION, 'all');
    }

    public function isFluentPages()
    {
        return Helper::isFluentAdminPage();
    }

    public function enqueuePageScripts()
    {
        if (!$this->isFluentPages()) {
            return;
        }

        wp_enqueue_script('fluent_forms_global');
        wp_localize_script('fluent_forms_global', 'fluent_forms_global_var', [
        	'fluent_forms_admin_nonce' => wp_create_nonce('fluent_forms_admin_nonce'),
	        'ajaxurl' => admin_url('admin-ajax.php'),
            'admin_i18n'=> $this->getAdminI18n()
        ]);

        $page = sanitize_text_field($_GET['page']);

        if ($page == 'fluent_forms' && isset($_GET['route']) && isset($_GET['form_id'])) {
            wp_enqueue_style('fluentform_settings_global');
            wp_enqueue_script('clipboard');
            wp_enqueue_script('copier');

            if ($_GET['route'] == 'settings') {
                if (function_exists('wp_enqueue_editor')) {
                    add_filter('user_can_richedit', function ($status) {
                        return true;
                    });

                    wp_enqueue_editor();
                    wp_enqueue_media();
                }

                wp_enqueue_script('fluentform_form_settings');

            } else if ($_GET['route'] == 'editor') {
                $this->enqueueEditorAssets();
            }
        } else if ($page == 'fluent_forms') {
            wp_enqueue_script('fluent_all_forms');
            wp_enqueue_style('fluent_all_forms');
        } else if ($page == 'fluent_forms_transfer') {
            wp_enqueue_style('fluentform_settings_global');
            wp_enqueue_script('fluentform-transfer-js');
        } else if (
            $page == 'fluent_forms_settings' ||
            $page == 'fluent_forms_payment_entries' ||
            $page == 'fluent_forms_all_entries'
        ) {
            wp_enqueue_style('fluentform_settings_global');
        } else if ($page == 'fluent_forms_add_ons') {
            wp_enqueue_style('fluentform-add-ons');
        } else if ($page == 'fluent_forms_docs' || $page == 'fluent_forms_smtp') {
            wp_enqueue_style('fluentform_doc_style');
        }
    }

    /**
     * Register menu and sub-menus.
     */
    public function register()
    {
        $dashBoardCapability = apply_filters(
            'fluentform_dashboard_capability', 'fluentform_settings_manager'
        );

        $settingsCapability = apply_filters(
            'fluentform_settings_capability', 'fluentform_settings_manager'
        );

        if (!current_user_can($dashBoardCapability) && !current_user_can($settingsCapability)) {
            $customRoles = get_option('_fluentform_form_permission');

            if (is_string($customRoles)) {
                $customRoles = [];
            }

            if (!$customRoles) {
                return;
            }

            $hasAccess = false;
            foreach ($customRoles as $roleName) {
                if (current_user_can($roleName)) {
                    $hasAccess = true;
                    $dashBoardCapability = $roleName;
                    $settingsCapability = $roleName;
                }
            }

            if (!$hasAccess) {
                return;
            }
        }

        if (defined('FLUENTFORMPRO')) {
            $title = __('Fluent Forms Pro', 'fluentform');
        } else {
            $title = __('Fluent Forms', 'fluentform');
        }

        $menuPriority = 25;

        if(defined('FLUENTCRM')) {
            $menuPriority = 3;
        }

        add_menu_page(
            $title,
            $title,
            $dashBoardCapability,
            'fluent_forms',
            array($this, 'renderFormAdminRoute'),
            $this->getMenuIcon(),
            $menuPriority
        );


        add_submenu_page(
            'fluent_forms',
            __('All Forms', 'fluentform'),
            __('All Forms', 'fluentform'),
            $dashBoardCapability,
            'fluent_forms',
            array($this, 'renderFormAdminRoute')
        );

        if ($settingsCapability) {
            add_submenu_page(
                'fluent_forms',
                __('New Form', 'fluentform'),
                __('New Form', 'fluentform'),
                $settingsCapability,
                'fluent_forms#add=1',
                array($this, 'renderFormAdminRoute')
            );

            $entriesTitle =  __('Entries', 'fluentform');

            if(Helper::isFluentAdminPage()) {
                $entriesCount = wpFluent()->table('fluentform_submissions')
                    ->where('status', 'unread')
                    ->count();
                if($entriesCount) {
                    $entriesTitle .= ' <span class="ff_unread_count" style="background: #ca4a20;color: white;border-radius: 8px;padding: 1px 8px;">'.$entriesCount.'</span>';
                }
            }

            // Register entries intermediary page
            add_submenu_page(
                'fluent_forms',
                $entriesTitle,
                $entriesTitle,
                $settingsCapability,
                'fluent_forms_all_entries',
                array($this, 'renderAllEntriesAdminRoute')
            );

            if (apply_filters('fluentform_show_payment_entries', false)) {
                add_submenu_page(
                    'fluent_forms',
                    __('Payments', 'fluentform'),
                    __('Payments', 'fluentform'),
                    $settingsCapability,
                    'fluent_forms_payment_entries',
                    array($this, 'renderPaymentEntries')
                );
            }

        }


        // Register Add-Ons
        add_submenu_page(
            'fluent_forms',
            __('Integration Modules', 'fluentform'),
            __('Integration Modules', 'fluentform'),
            $dashBoardCapability,
            'fluent_forms_add_ons',
            array($this, 'renderAddOns')
        );

        if ($settingsCapability) {
            // Register global settings sub menu page.
            add_submenu_page(
                'fluent_forms',
                __('Global Settings', 'fluentform'),
                __('Global Settings', 'fluentform'),
                $settingsCapability,
                'fluent_forms_settings',
                array($this, 'renderGlobalSettings')
            );

            // Register import/export sub menu page.
            add_submenu_page(
                'fluent_forms',
                __('Tools', 'fluentform'),
                __('Tools', 'fluentform'),
                $settingsCapability,
                'fluent_forms_transfer',
                array($this, 'renderTransfer')
            );

            // Register FluentSMTP Sub Menu.
            add_submenu_page(
                'fluent_forms',
                __('SMTP', 'fluentform'),
                __('SMTP', 'fluentform'),
                $settingsCapability,
                'fluent_forms_smtp',
                array($this, 'renderSmtpPromo')
            );
        }


        // Register Documentation
        add_submenu_page(
            'fluent_forms',
            __('Get Help', 'fluentform'),
            __('Get Help', 'fluentform'),
            $dashBoardCapability,
            'fluent_forms_docs',
            array($this, 'renderDocs')
        );

        $this->commonAction();

    }

    private function getMenuIcon()
    {
        return 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><defs><style>.cls-1{fill:#fff;}</style></defs><title>dashboard_icon</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M15.57,0H4.43A4.43,4.43,0,0,0,0,4.43V15.57A4.43,4.43,0,0,0,4.43,20H15.57A4.43,4.43,0,0,0,20,15.57V4.43A4.43,4.43,0,0,0,15.57,0ZM12.82,14a2.36,2.36,0,0,1-1.66.68H6.5A2.31,2.31,0,0,1,7.18,13a2.36,2.36,0,0,1,1.66-.68l4.66,0A2.34,2.34,0,0,1,12.82,14Zm3.3-3.46a2.36,2.36,0,0,1-1.66.68H3.21a2.25,2.25,0,0,1,.68-1.64,2.36,2.36,0,0,1,1.66-.68H16.79A2.25,2.25,0,0,1,16.12,10.53Zm0-3.73a2.36,2.36,0,0,1-1.66.68H3.21a2.25,2.25,0,0,1,.68-1.64,2.36,2.36,0,0,1,1.66-.68H16.79A2.25,2.25,0,0,1,16.12,6.81Z"/></g></g></svg>');
    }

    public function renderFormAdminRoute()
    {
        if (isset($_GET['route']) && isset($_GET['form_id'])) {
            return $this->renderFormInnerPages();
        }

        $this->renderForms();
    }

    public function renderAllEntriesAdminRoute()
    {
        wp_enqueue_script('fluentform_all_entries');
        View::render('admin.all_entries', array());
    }

    private function renderFormInnerPages()
    {
        $form_id = intval($_GET['form_id']);
        $form = wpFluent()->table('fluentform_forms')->find($form_id);

        if (!$form) {
            echo __("<h2>No form found</h2>", 'fluentform');
            return;
        }

        $formAdminMenus = array(
            'editor' => array(
                'slug' => 'editor',
                'title' => __('Editor', 'fluentform'),
                'url' => admin_url('admin.php?page=fluent_forms&form_id=' . $form_id . '&route=editor')
            ),
            'settings' => array(
                'slug' => 'settings',
                'hash' => 'basic_settings',
                'title' => __('Settings & Integrations', 'fluentform'),
                'sub_route' => 'form_settings',
                'url' => admin_url('admin.php?page=fluent_forms&form_id=' . $form_id . '&route=settings&sub_route=form_settings')
            ),
            'entries' => array(
                'slug' => 'entries',
                'hash' => '/',
                'title' => __('Entries', 'fluentform'),
                'url' => admin_url('admin.php?page=fluent_forms&form_id=' . $form_id . '&route=entries')
            )
        );

        $formAdminMenus = apply_filters('fluentform_form_admin_menu', $formAdminMenus, $form_id, $form);


        $route = sanitize_key($_GET['route']);

        View::render('admin.form.form_wrapper', array(
            'route' => $route,
            'form_id' => $form_id,
            'form' => $form,
            'menu_items' => $formAdminMenus
        ));
    }

    public function renderSettings($form_id)
    {
        $settingsMenus = array(
            'form_settings' => array(
                'title' => __('Form Settings', 'fluentform'),
                'slug' => 'form_settings',
                'hash' => 'basic_settings',
                'route' => '/'
            ),
            'email_notifications' => array(
                'title' => __('Email Notifications', 'fluentform'),
                'slug' => 'form_settings',
                'hash' => 'email_notifications',
                'route' => '/email-settings'
            ),
            'other_confirmations' => array(
                'title' => __('Other Confirmations', 'fluentform'),
                'slug' => 'form_settings',
                'hash' => 'other_confirmations',
                'route' => '/other-confirmations'
            ),
            'all_integrations' => array(
                'title' => __('Marketing & CRM Integrations', 'fluentform'),
                'slug' => 'form_settings',
                'route' => '/all-integrations'
            )
        );

        if (Helper::isSlackEnabled()) {
            $settingsMenus['slack'] = array(
                'title' => __('Slack', 'fluentform'),
                'slug' => 'form_settings',
                'hash' => 'slack',
                'route' => '/slack'
            );
        }

        $settingsMenus = apply_filters('fluentform_form_settings_menu', $settingsMenus, $form_id);

        $externalMenuItems = [];
        foreach ($settingsMenus as $key => $menu) {
            if (empty($menu['hash'])) {
                unset($settingsMenus[$key]);
                $externalMenuItems[$key] = $menu;
            }
        }

        $settingsMenus['custom_css_js'] = array(
            'title' => __('Custom CSS/JS', 'fluentform'),
            'slug' => 'form_settings',
            'hash' => 'custom_css_js',
            'route' => '/custom-css-js'
        );

        $settingsMenus = array_filter(array_merge($settingsMenus, $externalMenuItems));

        $currentRoute = sanitize_key($this->app->request->get('sub_route', ''));

        View::render('admin.form.settings_wrapper', array(
            'form_id' => $form_id,
            'settings_menus' => $settingsMenus,
            'current_sub_route' => $currentRoute
        ));
    }

    /**
     * Remove the inactive addOn menu items
     * @param string $addOn
     * @return boolean
     */
    public function filterFormSettingsMenu($settingsMenus, $form_id)
    {
        if (array_key_exists('mailchimp_integration', $settingsMenus)) {
            $option = (array)get_option('_fluentform_mailchimp_details');
            if (!isset($option['status']) || !$option['status']) {
                unset($settingsMenus['mailchimp_integration']);
            }
        }

        return $settingsMenus;
    }

    public function renderFormSettings($form_id)
    {
        wp_localize_script('fluentform_form_settings', 'FluentFormApp', array(
            'form_id' => $form_id,
            'plugin' => $this->app->getSlug(),
            'hasPro' => defined('FLUENTFORMPRO'),
            'hasPDF' => defined('FLUENTFORM_PDF_VERSION'),
            'hasFluentCRM' => defined('FLUENTCRM'),
            'upgrade_url' => fluentform_upgrade_url(),
            'ace_path_url' => $this->app->publicUrl('libs/ace'),
            'is_conversion_form' => Helper::isConversionForm($form_id),
            'has_fluent_smtp' => defined('FLUENTMAIL'),
            'fluent_smtp_url' => admin_url('admin.php?page=fluent_forms_smtp')
        ));

        View::render('admin.form.settings', array(
            'form_id' => $form_id
        ));
    }

    public function renderForms()
    {
        if (!get_option('_fluentform_installed_version')) {
            (new Activator())->migrate();
        }

        $formsCount = wpFluent()->table('fluentform_forms')->count();

        wp_localize_script('fluent_all_forms', 'FluentFormApp', apply_filters('fluent_all_forms_vars', array(
            'plugin' => $this->app->getSlug(),
            'formsCount' => $formsCount,
            'hasPro' => defined('FLUENTFORMPRO'),
            'upgrade_url' => fluentform_upgrade_url(),
            'adminUrl' => admin_url('admin.php?page=fluent_forms'),
            'isDisableAnalytics' => apply_filters('fluentform-disabled_analytics', false)
        )));

        View::render('admin.all_forms', array());
    }

    public function renderEditor($form_id)
    {
        View::render('admin.form.editor', array(
            'plugin' => $this->app->getSlug(),
            'form_id' => $form_id
        ));
    }

    public function renderDocs()
    {
        echo (new DocumentationModule())->render();
    }

    public function renderAddOns()
    {
        echo (new AddOnModule())->render();
    }

    private function enqueueEditorAssets()
    {
        $formId = intval($_GET['form_id']);

        $form = wpFluent()->table('fluentform_forms')->find($formId);

        do_action('fluentform_loading_editor_assets', $form);

        wp_enqueue_style('fluentform_editor_sass');
        wp_enqueue_style('fluentform_editor_style');

        $pluginSlug = $this->app->getSlug();

        if (function_exists('wp_enqueue_editor')) {
            add_filter('user_can_richedit', '__return_true');
            wp_enqueue_editor();
            wp_enqueue_media();
        }

        wp_enqueue_script('fluentform_editor_script');

        $jsonData = $form->form_fields;

        if (!defined('FLUENTFORM_DISABLE_EDITOR_FILED_HOOOK')) {
            $formFields = $form->form_fields;

            if ($formFields) {
                $formFields = json_decode($formFields, true);

                foreach ($formFields['fields'] as $index => $formField) {
                    $formFields['fields'][$index] = apply_filters(
                        'fluentform_editor_init_element_' . $formField['element'], $formField, $form
                    );

                    if (!$formFields['fields'][$index]) {
                        unset($formFields['fields'][$index]);
                        continue;
                    }

                    if ($formField['element'] == 'container') {
                        $columns = $formField['columns'];
                        foreach ($columns as $columnIndex => $column) {
                            foreach ($column['fields'] as $fieldIndex => $columnField) {
                                $columns[$columnIndex]['fields'][$fieldIndex] = apply_filters(
                                    'fluentform_editor_init_element_' . $columnField['element'],
                                    $columnField, $form
                                );

                                if (!$columns[$columnIndex]['fields'][$fieldIndex]) {
                                    unset($columns[$columnIndex]['fields'][$fieldIndex]);
                                }
                            }
                        }

                        $formFields['fields'][$index]['columns'] = array_values($columns);
                    }
                }

                $formFields['fields'] = array_values($formFields['fields']);
                $formFields = json_encode($formFields, true);
            }


            $form->form_fields = $formFields;
        }

        $searchTags = $this->app->load(
            $this->app->appPath('Services/FormBuilder/ElementSearchTags.php')
        );

        $searchTags = apply_filters( 'fluent_editor_element_search_tags', $searchTags, $form );

        $elementPlacements = apply_filters('fluent_editor_element_settings_placement',
            $this->app->load( $this->app->appPath('Services/FormBuilder/ElementSettingsPlacement.php') ), $form
        );

        wp_localize_script('fluentform_editor_script', 'FluentFormApp', apply_filters('fluentform_editor_vars', array(
            'plugin' => $pluginSlug,
            'form_id' => $formId,
            'plugin_public_url' => $this->app->publicUrl(),
            'preview_url' => Helper::getPreviewUrl($formId),
            'form' => $form,
            'hasPro' => defined('FLUENTFORMPRO'),
            'countries' => $this->app->load(
                $this->app->appPath('Services/FormBuilder/CountryNames.php')
            ),
            'element_customization_settings' => $this->app->load(
                $this->app->appPath('Services/FormBuilder/ElementCustomization.php')
            ),

            'validation_rule_settings' => $this->app->load(
                $this->app->appPath('Services/FormBuilder/ValidationRuleSettings.php')
            ),

            'element_search_tags' => $searchTags,

            'element_settings_placement' => $elementPlacements,
            'all_forms_url' => admin_url('admin.php?page=fluent_forms'),
            'has_payment_features' => !defined('FLUENTFORMPRO'),
            'upgrade_url' => fluentform_upgrade_url(),
            'is_conversion_form' => Helper::isConversionForm($formId),
            'bulk_options_json' => '{"Countries":["Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bonaire, Sint Eustatius and Saba","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos Islands","Colombia","Comoros","Congo, Democratic Republic of the","Congo, Republic of the","Cook Islands","Costa Rica","Croatia","Cuba","Cura\u00e7ao","Cyprus","Czech Republic","C\u00f4te d\'Ivoire","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini (Swaziland)","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Heard and McDonald Islands","Holy See","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait","Kyrgyzstan","Lao People\'s Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine, State of","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Romania","Russia","Rwanda","R\u00e9union","Saint Barth\u00e9lemy","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Martin","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Sint Maarten","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia","South Korea","South Sudan","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen Islands","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","US Minor Outlying Islands","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe","\u00c5land Islands"],"U.S. States":["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District of Columbia","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming","Armed Forces Americas","Armed Forces Europe","Armed Forces Pacific"],"Canadian Province\/Territory":["Alberta","British Columbia","Manitoba","New Brunswick","Newfoundland and Labrador","Northwest Territories","Nova Scotia","Nunavut","Ontario","Prince Edward Island","Quebec","Saskatchewan","Yukon"],"Continents":["Africa","Antarctica","Asia","Australia","Europe","North America","South America"],"Gender":["Male","Female","Prefer Not to Answer"],"Age":["Under 18","18-24","25-34","35-44","45-54","55-64","65 or Above","Prefer Not to Answer"],"Marital Status":["Single","Married","Divorced","Widowed"],"Employment":["Employed Full-Time","Employed Part-Time","Self-employed","Not employed but looking for work","Not employed and not looking for work","Homemaker","Retired","Student","Prefer Not to Answer"],"Job Type":["Full-Time","Part-Time","Per Diem","Employee","Temporary","Contract","Intern","Seasonal"],"Industry":["Accounting\/Finance","Advertising\/Public Relations","Aerospace\/Aviation","Arts\/Entertainment\/Publishing","Automotive","Banking\/Mortgage","Business Development","Business Opportunity","Clerical\/Administrative","Construction\/Facilities","Consumer Goods","Customer Service","Education\/Training","Energy\/Utilities","Engineering","Government\/Military","Green","Healthcare","Hospitality\/Travel","Human Resources","Installation\/Maintenance","Insurance","Internet","Job Search Aids","Law Enforcement\/Security","Legal","Management\/Executive","Manufacturing\/Operations","Marketing","Non-Profit\/Volunteer","Pharmaceutical\/Biotech","Professional Services","QA\/Quality Control","Real Estate","Restaurant\/Food Service","Retail","Sales","Science\/Research","Skilled Labor","Technology","Telecommunications","Transportation\/Logistics","Other"],"Education":["High School","Associate Degree","Bachelor\'s Degree","Graduate or Professional Degree","Some College","Other","Prefer Not to Answer"],"Days of the Week":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"Months of the Year":["January","February","March","April","May","June","July","August","September","October","November","December"],"How Often":["Every day","Once a week","2 to 3 times a week","Once a month","2 to 3 times a month","Less than once a month"],"How Long":["Less than a month","1-6 months","1-3 years","Over 3 years","Never used"],"Satisfaction":["Very Satisfied","Satisfied","Neutral","Unsatisfied","Very Unsatisfied"],"Importance":["Very Important","Important","Somewhat Important","Not Important"],"Agreement":["Strongly Agree","Agree","Disagree","Strongly Disagree"],"Comparison":["Much Better","Somewhat Better","About the Same","Somewhat Worse","Much Worse"],"Would You":["Definitely","Probably","Not Sure","Probably Not","Definitely Not"],"Size":["Extra Small","Small","Medium","Large","Extra Large"]}'
        )));
    }

    /**
     * Render global settings page.
     *
     * @throws \Exception
     */
    public function renderGlobalSettings()
    {
        if (function_exists('wp_enqueue_editor')) {
            add_filter('user_can_richedit', '__return_true');
            wp_enqueue_editor();
            wp_enqueue_media();
        }

        // Fire an event letting others know the current component
        // that fluentform is rendering for the global settings
        // page. So that they can hook and load their custom
        // components on this page dynamically & easily.
        // N.B. native 'components' will always use
        // 'settings' as their current component.
        $currentComponent = apply_filters('fluentform_global_settings_current_component',
            $this->app->request->get('component', 'settings')
        );


        $currentComponent = sanitize_key($currentComponent);

        $components = apply_filters('fluentform_global_settings_components', []);

        $components['reCAPTCHA'] = [
            'hash' => 're_captcha',
            'title' => 'reCAPTCHA',
        ];

        $components['hCAPTCHA'] = [
            'hash' => 'h_captcha',
            'title' => 'hCAPTCHA',
        ];

        View::render('admin.settings.index', [
            'components' => $components,
            'currentComponent' => $currentComponent
        ]);
    }

    public function renderTransfer()
    {
        $forms = wpFluent()->table('fluentform_forms')
            ->orderBy('id', 'desc')
            ->select(['id', 'title'])
            ->get();

        wp_localize_script('fluentform-transfer-js', 'FluentFormApp', [
            'plugin' => $this->app->getSlug(),
            'forms' => $forms,
            'upgrade_url' => fluentform_upgrade_url(),
            'hasPro' => defined('FLUENTFORMPRO'),
        ]);

        View::render('admin.transfer.index');
    }

    public function addPreviewButton($formId)
    {
        $previewText = __('Preview & Design', 'fluent-form');
        $previewUrl = Helper::getPreviewUrl($formId);
        if($isConversational = Helper::isConversionForm($formId)) {
            $previewText = __('Preview', 'fluent-form');
        }

        echo '<a target="_blank" class="el-button el-button--small" href="' . $previewUrl . '">'.$previewText.'</a>';
    }

    public function addCopyShortcodeButton($formId)
    {
        $shortcode = '[fluentform id="' . $formId . '"]';
        if(Helper::isConversionForm($formId)) {
            $shortcode = '[fluentform type="conversational" id="' . $formId . '"]';
        }
        echo '<button style="background:#dedede;color:#545454;padding:5px;max-width: 200px;overflow: hidden;" title="Click to Copy" class="btn copy" data-clipboard-text=\''.$shortcode.'\'><i class="dashicons dashicons-admin-page" style="color:#eee;text-shadow:#000 -1px 1px 1px;"></i> '.$shortcode.'</button>';
        return;
    }

    public function commonAction()
    {
        $fluentFormPages = array(
            'fluent_forms',
            'fluent_forms_transfer',
            'fluent_forms_settings',
            'fluent_forms_add_ons',
            'fluent_forms_docs',
            'fluent_forms_smtp'
        );

        if (isset($_GET['page']) && in_array($_GET['page'], $fluentFormPages)) {
            // Let's deregister existing vuejs by other devs
            // Other devs should not regis
            add_action('admin_print_scripts', function () {
                wp_dequeue_script('vuejs');
                wp_dequeue_script('vue');
                wp_deregister_script('elementor-admin-app');
            });
        }
    }

    public function renderGlobalMenu()
    {
        $showPayment = false;
        if(defined('FLUENTFORMPRO')) {
            $showPayment = !get_option('__fluentform_payment_module_settings');
            if($showPayment) {
                $formCount = wpFluent()->table('fluentform_forms')
                                ->count();
                $showPayment = $formCount > 2;
            }
        }
        View::render('admin.global_menu', array(
            'show_payment' => $showPayment,
            'show_payment_entries' => apply_filters('fluentform_show_payment_entries', false)
        ));
    }

    public function renderPaymentEntries()
    {
        do_action('flunetform_render_payment_entries');
    }

    public function renderSmtpPromo()
    {
        wp_enqueue_script('fluentform_admin_notice', fluentformMix('js/admin_notices.js'), array(
            'jquery'
        ), FLUENTFORM_VERSION);

        View::render('admin.smtp.index', [
            'logo' => $this->app->publicUrl('img/fluentsmtp.svg'),
            'banner_image' => $this->app->publicUrl('img/fluentsmtp-banner.png'),
            'is_installed' => defined('FLUENTMAIL'),
            'setup_url' => admin_url('options-general.php?page=fluent-mail#/connections')
        ]);
    }

    private function getAdminI18n()
    {
        $i18n = array(
            'All Forms' => __('All Forms', 'fluentform'),
            'Add a New Form' => __('Add a New Form', 'fluentform'),
            'Conversational Form' => __('Conversational Form', 'fluentform'),
            'Create Conversational Form' => __('Create Conversational Form', 'fluentform'),
            'ID' => __('ID', 'fluentform'),
            'Title' => __('Title', 'fluentform'),
            'Edit' => __('Edit', 'fluentform'),
            'Settings' => __('Settings', 'fluentform'),
            'Entries' => __('Entries', 'fluentform'),
            'Conversational Preview' => __('Conversational Preview', 'fluentform'),
            'Preview' => __('Preview', 'fluentform'),
            'Duplicate' => __('Duplicate', 'fluentform'),
            'Delete' => __('Delete', 'fluentform'),
            'Short Code' => __('Short Code', 'fluentform'),
            'Conversion' => __('Conversion', 'fluentform'),
            'Views' => __('Views', 'fluentform'),
            'Search Forms' => __('Search Forms', 'fluentform'),
            'Search' => __('Search', 'fluentform'),
            'Click Here to Create Your First Form' => __('Click Here to Create Your First Form', 'fluentform'),
            'Check the video intro' => __('Check the video intro', 'fluentform'),
            'All Form Entries' => __('All Form Entries', 'fluentform'),
            'Browser' => __('Browser', 'fluentform'),
            'Date' => __('Date', 'fluentform'),
            'Hide Chart' => __('Hide Chart', 'fluentform'),
            'Show Chart' => __('Show Chart', 'fluentform'),
            'All' => __('All', 'fluentform'),
            'Unread Only' => __('Unread Only', 'fluentform'),
            'Read Only' => __('Read Only', 'fluentform'),
            'Submission ID' => __('Submission ID', 'fluentform'),
            'Form' => __('Form', 'fluentform'),
            'Status' => __('Status', 'fluentform'),
            'Read' => __('Read', 'fluentform'),
            'Unread' => __('Unread', 'fluentform'),
            'ago' => __('ago', 'fluentform'),
            'Click to copy shortcode' => __('Click to copy shortcode', 'fluentform'),
            'Back to Entries' => __('Back to Entries', 'fluentform'),
            'Previous' => __('Previous', 'fluentform'),
            'Next' => __('Next', 'fluentform'),
            'Entry Details' => __('Entry Details', 'fluentform'),
            'Form Entry Data' => __('Form Entry Data', 'fluentform'),
            'Remove from Favorites' => __('Remove from Favorites', 'fluentform'),
            'Mark as Favorite' => __('Mark as Favorite', 'fluentform'),
            'Submission Info' => __('Submission Info', 'fluentform'),
            'Entity ID' => __('Entity ID', 'fluentform'),
            'User IP' => __('User IP', 'fluentform'),
            'Device' => __('Device', 'fluentform'),
            'User' => __('User', 'fluentform'),
            'Guest' => __('Guest', 'fluentform'),
            'Submitted On' => __('Submitted On', 'fluentform'),
            'Change status to' => __('Change status to', 'fluentform'),
            'Show empty fields' => __('Show empty fields', 'fluentform'),
            'Submission Notes' => __('Submission Notes', 'fluentform'),
            'Please Provide Note Content' => __('Please Provide Note Content', 'fluentform'),
            'No Notes found' => __('No Notes found', 'fluentform'),
            'All Types' => __('All Types', 'fluentform'),
            'Export' => __('Export', 'fluentform'),
            'Export as' => __('Export as', 'fluentform'),
            'Advanced Filter' => __('Advanced Filter', 'fluentform'),
            'Filter By Date Range' => __('Filter By Date Range', 'fluentform'),
            'Favorites Entries only' => __('Favorites Entries only', 'fluentform'),
            'Amount' => __('Amount', 'fluentform'),
            'Actions' => __('Actions', 'fluentform'),
            'Submitted at' => __('Submitted at', 'fluentform'),
            'Submission Logs' => __('Submission Logs', 'fluentform'),
            'General' => __('General', 'fluentform'),
            'API Calls' => __('API Calls', 'fluentform'),
            'No Logs found' => __('No Logs found', 'fluentform'),
            'Submission Notes' => __('Submission Notes', 'fluentform'),
            'Add Note' => __('Add Note', 'fluentform'),
            'No Notes found' => __('No Notes found', 'fluentform'),
            );

        return apply_filters('fluentform/admin_i18n', $i18n);
    }
}
