<?php namespace FluentForm\App\Modules\Track;

use FluentForm\AdminNotice;
use FluentForm\App;
use FluentForm\Framework\Helpers\ArrayHelper;

class TrackModule
{
	private $apiUrl = 'https://fluentform.com';
	private $initialConsentKey = '_fluentform_notice_pref';
	private $newsletterDelayTimeStamp = 172800; // 7 days
	
	public function initTrack()
	{
		if( AdminNotice::shouldShowNotice('track_data_notice') && $this->isLocalhost() ) {
			$this->showInitialConsent();
		}
	}
	
	public function showInitialConsent()
    {
	    $notice = $this->getInitialNotice();
	    AdminNotice::addNotice($notice);
    }
    
    public function rejectTrack() 
    {
	    $notice_name = sanitize_text_field($_REQUEST['notice_name']);
	    $action_type = sanitize_text_field($_REQUEST['action_type']);
	    $notificationPref = get_option($this->initialConsentKey, array());
	    
		if($action_type == 'permanent') {
			$notificationPref[$notice_name] = array(
				'status' => 'no',
				'email_subscribed' => 'no',
				'timestamp' => time(),
				'temp_disabled' => false
			);
		} else {
			$notificationPref[$notice_name] = array(
				'status' => 'no',
				'email_subscribed' => 'no',
				'timestamp' => time(),
				'temp_disabled' => true
			);
		}

	    update_option($this->initialConsentKey, $notificationPref, 'no');
    }
    
    public function sendInitialInfo()
    {
        $email_enabled = sanitize_text_field($_REQUEST['email_enabled']);
        $notice_name = sanitize_text_field($_REQUEST['notice_name']);
        
        $notificationPref = get_option($this->initialConsentKey, array());
        
        $notificationPref[$notice_name] = array(
		    'status' => 'yes',
		    'email_subscribed' => ($email_enabled) ? 'yes' : 'no',
		    'timestamp' => time()
	    );
        
        update_option($this->initialConsentKey, $notificationPref, 'no');
        
        $logData = $this->getLogData();
        $logData['email_subscribed'] = $email_enabled;
		
		try {
			wp_remote_post(
				$this->apiUrl,
				array(
					'body' => array(
						'plugin_log_id' => 1,
						'plugin'          => 'fluentform',
						'data'          =>  $logData
					)
				)
			);
		} catch (\Exception $exception) {
			// ...
		}
    }
    
    private function getLogData()
    {
	    global $wpdb;
	    //WP_DEBUG
	    if ( defined('WP_DEBUG') && WP_DEBUG ){
		    $debug = 1;
	    } else {
		    $debug =  0;
	    }

	    //WPLANG
	    if ( defined( 'WPLANG' ) && WPLANG ) {
		    $lang = WPLANG;
	    } else {
		    $lang = 'default';
	    }

	    $ip_address = '';
	    if ( array_key_exists( 'SERVER_ADDR', $_SERVER ) ) {
		    $ip_address = $_SERVER[ 'SERVER_ADDR' ];
	    } else if ( array_key_exists( 'LOCAL_ADDR', $_SERVER ) ) {
		    $ip_address = $_SERVER[ 'LOCAL_ADDR' ];
	    }
	    
	    $host_name = gethostbyaddr( $ip_address );

	    $active_plugins = (array) get_option( 'active_plugins', array() );
	    $current_user = wp_get_current_user();
	    if ( ! empty ( $current_user->user_email ) ) {
		    $email = $current_user->user_email;
	    } else {
		    $email = get_option( 'admin_email' );
	    }
	    
	    $data = array(
		    'version'                   => App::getVersion(),
		    'wp_version'                => get_bloginfo('version'),
		    'multisite_enabled'         => is_multisite(),
		    'server_type'               => $_SERVER['SERVER_SOFTWARE'],
		    'php_version'               => phpversion(),
		    'mysql_version'             => $wpdb->db_version(),
		    'wp_memory_limit'           => WP_MEMORY_LIMIT,
		    'wp_debug_mode'             => $debug,
		    'wp_lang'                   => $lang,
		    'wp_max_upload_size'        => size_format( wp_max_upload_size() ),
		    'php_max_post_size'         => ini_get( 'post_max_size' ),
		    'hostname'                  => $host_name,
		    'smtp'                      => ini_get('SMTP'),
		    'smtp_port'                 => ini_get('smtp_port'),
		    'active_plugins'            => $active_plugins,
		    'email'                     => $email,
		    'display_name'              => $current_user->display_name,
		    'ip_address' => $ip_address,
		    'domain' => site_url()
	    );
	    
	    return $data;
    }

	public function getInitialNotice()
	{
		return array(
			'name' => 'track_data_notice',
			'title' => __( 'Want to make Fluent Forms better with just one click?', 'ninja-forms' ),
			'message' => 'We will collect a few server data if you permit us. It will help us troubleshoot any inconveniences you may face while using FluentForm, and guide us to add better features according to your usage. NO FORM SUBMISSION DATA WILL BE COLLECTED.<br/><input checked type="checkbox" id="ff-optin-send-email"> You can also send me Fluent Forms tips and tricks occasionally',
			'links' => array(
				array(
					'href' => admin_url('admin.php?page=fluent_forms'),
					'btn_text' => 'Yes, I want to make Fluent Forms Better',
					'btn_atts' => 'class="button-primary ff_track_yes" data-notice_name="track_data_notice"'
				),
				array(
					'href' => admin_url('admin.php?page=fluent_forms'),
					'btn_text' => 'No, Please don\'t collect errors or other data',
					'btn_atts' => 'class="button-secondary ff_nag_cross" data-notice_type="permanent" data-notice_name="track_data_notice"'
				)
			),
		);
	}
	
	
	private function isLocalhost()
	{
		return in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) );
	}
}
