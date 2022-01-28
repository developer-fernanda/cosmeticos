<?php
/*
Plugin Name: Fluent Forms
Description: Contact Form By Fluent Forms is the advanced Contact form plugin with drag and drop, multi column supported form builder plugin
Version: 4.3.0
Author: Contact Form - WPManageNinja LLC
Author URI: https://fluentforms.com
Plugin URI: https://wpmanageninja.com/wp-fluent-form/
License: GPLv2 or later
Text Domain: fluentform
Domain Path: /resources/languages
*/

defined('ABSPATH') or die;

defined('FLUENTFORM') or define('FLUENTFORM', true);
define('FLUENTFORM_DIR_PATH', plugin_dir_path(__FILE__));

defined('FLUENTFORM_VERSION') or define('FLUENTFORM_VERSION', '4.3.0');

if (!defined('FLUENTFORM_HAS_NIA')) {
    define('FLUENTFORM_HAS_NIA', true);
}

include FLUENTFORM_DIR_PATH . 'framework/Foundation/Bootstrap.php';

use FluentForm\Framework\Foundation\Bootstrap;

Bootstrap::run(__FILE__);

// Handle Newtwork new Site Activation
add_action('wp_insert_site', function ($blog) {
    switch_to_blog($blog->blog_id);
    include_once plugin_dir_path(__FILE__) . 'app/Modules/Activator.php';
    (new FluentForm\App\Modules\Activator)->migrate();
    restore_current_blog();
});
