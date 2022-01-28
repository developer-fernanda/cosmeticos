<?php

/**
 * Declare frontend actions/filters/shortcodes
 */

//if ($app->getEnv() == 'dev') {
//	add_filter('init', function() use ($app) {
//		if ($header = $app->request->header('X-HOOK')) {
//			error_log($header);
//		}
//	});
//}


/*
 * Exclude For WP Rocket Settings
 */
if(defined('WP_ROCKET_VERSION')) {
    add_filter('rocket_excluded_inline_js_content', function ($lines) {
        $lines[] = 'fluent_form_ff_form_instance';
        $lines[] = 'fluentFormVars';
        $lines[] = 'fluentform_payment';
        return $lines;
    });
}
