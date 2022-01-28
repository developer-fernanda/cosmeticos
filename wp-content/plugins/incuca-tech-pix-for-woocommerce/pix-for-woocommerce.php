<?php

/**
 * Plugin Name: InCuca Tech - Pix for WooCommerce
 * Plugin URI: https://github.com/InCuca/woocommerce-pix
 * Description: Aceite pagamentos com Pix.
 * Author: InCuca Tech
 * Author URI: https://incuca.net
 * Version: 1.3.6
 * Tested up to: 5.8.1
 * License: GNU General Public License v3.0
 *
 * @package Pix_For_WooCommerce
 */

defined('ABSPATH') or exit;

define('WC_PIX_VERSION', '1.3.6');
define('WC_PIX_PLUGIN_FILE', __FILE__);
define('WC_PIX_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WC_PIX_PLUGIN_PATH', plugin_dir_path(__FILE__));

if (!class_exists('WC_Pix')) {
	include_once dirname(__FILE__) . '/includes/class-wc-pix.php';
	add_action('plugins_loaded', array('WC_Pix', 'init'));
}
