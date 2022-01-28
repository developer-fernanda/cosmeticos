<?php

namespace FluentForm\App\Modules;

use FluentForm\App;
use FluentForm\View;

class AddOnModule
{
    /**
     * The number of days we'll cached the add-ons got from remote server.
     *
     * @var integer
     */
    protected $cacheDays = 1;

    /**
     * The URL to fetch the add-ons
     *
     * @var string
     */
    protected $addOnsFetchUrl = 'https://wpmanageninja.com/add-ons.json';

    /**
     * Render the add-ons list page.
     */
    public function render()
    {
        $extraMenus = [];

        $extraMenus = apply_filters('fluentform_addons_extra_menu', $extraMenus);


        $current_menu_item = 'fluentform_add_ons';

        if (isset($_GET['sub_page']) && $_GET['sub_page']) {
            $current_menu_item = sanitize_key($_GET['sub_page']);
        }

        return View::make('admin.addons.index', [
            'menus'             => $extraMenus,
            'base_url'          => admin_url('admin.php?page=fluent_forms_add_ons'),
            'current_menu_item' => $current_menu_item
        ]);
    }

    /**
     * Show the add-ons list.
     */
    public function showFluentAddOns()
    {
        wp_enqueue_script('fluentform-modules');

        $addOns = apply_filters('fluentform_global_addons', []);

        $addOns['slack'] = [
            'title'       => 'Slack',
            'description' => 'Get realtime notification in slack channel when a new submission will be added.',
            'logo'        => App::publicUrl('img/integrations/slack.png'),
            'enabled'     => App\Helpers\Helper::isSlackEnabled() ? 'yes' : 'no',
            'config_url'  => '',
            'category'    => 'crm'
        ];

        if (!defined('FLUENTFORMPRO')) {
            $addOns = array_merge($addOns, $this->getPremiumAddOns());
        }

        wp_localize_script('fluentform-modules', 'fluent_addon_modules', [
            'addons'  => $addOns,
            'has_pro' => defined('FLUENTFORMPRO')
        ]);

        View::render('admin.addons.list', []);
    }

    public function updateAddOnsStatus()
    {
        $addons = wp_unslash($_REQUEST['addons']);
        update_option('fluentform_global_modules_status', $addons, 'no');

        wp_send_json_success([
            'message' => 'Status successfully updated'
        ], 200);
    }

    public function getPremiumAddOns()
    {
        $purchaseUrl = fluentform_upgrade_url();
        return array(
            'paypal'  => array(
                'title'        => 'PayPal',
                'description'  => 'Accept Payments via paypal as a part of your form submission',
                'logo'         => App::publicUrl('img/integrations/paypal.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'payment'
            ),
            'stripe'  => array(
                'title'        => 'Stripe',
                'description'  => 'Accept Payments via stripe as a part of your form submission',
                'logo'         => App::publicUrl('img/integrations/stripe.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'payment'
            ),
            'UserRegistration'  => array(
                'title'        => 'User Registration',
                'description'  => 'Create WordPress user when when a form is submitted',
                'logo'         => App::publicUrl('img/integrations/user_registration.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'wp_core'
            ),
            'PostFeeds'         => array(
                'title'        => 'Advanced Post/CPT Creation',
                'description'  => 'Create post/any cpt on form submission. It will enable many new features including dedicated post fields.',
                'logo'         => App::publicUrl('img/integrations/post-creation.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'wp_core'
            ),
            'sharePages' => array(
                'title'       => 'Landing Pages',
                'description' => 'Create completely custom "distraction-free" form landing pages to boost conversions',
                'logo'        => App::publicUrl('img/integrations/landing_pages.png'),
                'enabled'     => 'no',
                'purchase_url' => $purchaseUrl,
                'category'    => 'wp_core'
            ),
            'webhook'           => array(
                'title'        => 'WebHooks',
                'description'  => 'Broadcast your WP Fluent Forms Submission to any web api endpoint with the powerful webhook module.',
                'logo'         => App::publicUrl('img/integrations/webhook.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'zapier'            => array(
                'title'        => 'Zapier',
                'description'  => 'Connect your WP Fluent Forms data with Zapier and push data to thousands of online softwares.',
                'logo'         => App::publicUrl('img/integrations/zapier.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'trello'            => array(
                'title'        => 'Trello',
                'description'  => 'WP Fluent Forms Trello Module allows you to create Trello card from submiting forms.',
                'logo'         => App::publicUrl('img/integrations/trello.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'google_sheet'      => array(
                'title'        => 'Google Sheet',
                'description'  => 'Add WP Fluent Forms Submission to Google sheets when a form is submitted.',
                'logo'         => App::publicUrl('img/integrations/google-sheets.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'activecampaign'    => array(
                'title'        => 'ActiveCampaign',
                'description'  => 'WP Fluent Forms ActiveCampaign Module allows you to create ActiveCampaign list signup forms in WordPress, so you can grow your email list.',
                'logo'         => App::publicUrl('img/integrations/activecampaign.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'campaign_monitor'  => array(
                'title'        => 'CampaignMonitor',
                'description'  => 'WP Fluent Forms Campaign Monitor module allows you to create Campaign Monitor newsletter signup forms in WordPress, so you can grow your email list.',
                'logo'         => App::publicUrl('img/integrations/campaignmonitor.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'constatantcontact' => array(
                'title'        => 'ConstantContact',
                'description'  => 'Connect ConstantContact with WP Fluent Forms and create subscriptions forms right into WordPress and grow your list.',
                'logo'         => App::publicUrl('img/integrations/constantcontact.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'convertkit'        => array(
                'title'        => 'ConvertKit',
                'description'  => 'Connect ConvertKit with WP Fluent Forms and create subscription forms right into WordPress and grow your list.',
                'logo'         => App::publicUrl('img/integrations/convertkit.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'getresponse'       => array(
                'title'        => 'GetResponse',
                'description'  => 'WP Fluent Forms GetResponse module allows you to create GetResponse newsletter signup forms in WordPress, so you can grow your email list.',
                'logo'         => App::publicUrl('img/integrations/getresponse.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'hubspot'           => array(
                'title'        => 'Hubspot',
                'description'  => 'Connect HubSpot with WP Fluent Forms and subscribe a contact when a form is submitted.',
                'logo'         => App::publicUrl('img/integrations/hubspot.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'icontact'          => array(
                'title'        => 'iContact',
                'description'  => 'Connect iContact with WP Fluent Forms and subscribe a contact when a form is submitted.',
                'logo'         => App::publicUrl('img/integrations/icontact.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'platformly'        => array(
                'title'        => 'Platformly',
                'description'  => 'Connect Platform.ly with WP Fluent Forms and subscribe a contact when a form is submitted.',
                'logo'         => App::publicUrl('img/integrations/platformly.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'moosend'           => array(
                'title'        => 'MooSend',
                'description'  => 'Connect MooSend with WP Fluent Forms and subscribe a contact when a form is submitted.',
                'logo'         => App::publicUrl('img/integrations/moosend_logo.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'sendfox'           => array(
                'title'        => 'SendFox',
                'description'  => 'Connect SendFox with WP Fluent Forms and subscribe a contact when a form is submitted.',
                'logo'         => App::publicUrl('img/integrations/sendfox.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'mailerlite'        => array(
                'title'        => 'MailerLite',
                'description'  => 'Connect your WP Fluent Forms with MailerLite and add subscribers easily.',
                'logo'         => App::publicUrl('img/integrations/mailerlite.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'sms_notifications' => array(
                'title'        => 'SMS Notification',
                'description'  => 'Send SMS in real time when a form is submitted with Twillio.',
                'logo'         => App::publicUrl('img/integrations/twillio.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'get_gist'          => array(
                'title'        => 'Gist',
                'description'  => 'GetGist is Easy to use all-in-one software for live chat, email marketing automation, forms, knowledge base, and more for a complete 360° view of your contacts.',
                'logo'         => App::publicUrl('img/integrations/getgist.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'sendinblue'        => array(
                'title'        => 'SendInBlue',
                'description'  => 'WP Fluent Forms Sendinblue Module allows you to create contacts on your list, so you can grow your email list.',
                'logo'         => App::publicUrl('img/integrations/sendinblue.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
            'drip'        => array(
                'title'        => 'Drip',
                'description'  => 'WP Fluent Forms Drip Module allows you to create contacts on your Drip list, so you can grow your email list.',
                'logo'         => App::publicUrl('img/integrations/drip.png'),
                'enabled'      => 'no',
                'purchase_url' => $purchaseUrl,
                'category'     => 'crm'
            ),
        );
    }
}
