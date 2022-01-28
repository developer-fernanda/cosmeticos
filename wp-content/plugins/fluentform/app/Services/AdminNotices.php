<?php namespace FluentForm\App\Services;

use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\View;

if ( ! defined( 'ABSPATH' ) ) exit;

class AdminNotices
{
	private $notice = false;
	private $noticeKey = false;
	private $noticeDisabledTime = 172800; // 7 days
	private $noticePrefKey = '_fluentform_notice_pref';
	private $app;
	private $pref = false;
	
	public function __construct(Application $app) {
		$this->app = $app;
	}

	public function showNotice()
	{
		if($notice = $this->notice) {
			$this->renderNotice($notice, $notice['name']);
		}
	}
	
	public function addNotice($notice)
	{
		$this->notice = $notice;
	}
	
	public function noticeActions()
	{
		$noticeName = sanitize_text_field($_REQUEST['notice_name']);
		$noticeType = sanitize_text_field($_REQUEST['action_type']);
		
		if($noticeName == 'track_data_notice') {
			$notificationPref = $this->getNoticePref();
			$notificationPref[$noticeName] = array(
				'status' => 'no',
				'email_subscribed' => 'no',
				'timestamp' => time()
			);
			update_option($this->noticePrefKey, $notificationPref, 'no');
			$this->pref = $notificationPref;
		}
		
		$this->disableNotice($noticeName, $noticeType);
		
		wp_send_json_success(array(
			'message' => 'success'
		), 200);
		die();
	}
	
	public function renderNotice($notice, $notice_key = false)
	{
		if(!$this->hasPermission())
			return;
		
		if($notice_key) {
			if(!$this->shouldShowNotice($notice_key)) {
				return;
			}
		}
		
		wp_enqueue_style('fluentform_admin_notice', fluentformMix('css/admin_notices.css'));
		wp_enqueue_script('fluentform_admin_notice', fluentformMix('js/admin_notices.js'), array(
			'jquery'
		), FLUENTFORM_VERSION);
		//print_r($notice);
		View::render('admin.notices.info', array(
			'notice' => $notice,
			'show_logo' => true,
			'show_hide_nag' => true,
			'logo_url' => $this->app->publicUrl('img/fluent_icon.png')
		));
	}
	
	public function hasNotice() 
	{
		return ($this->notice) ? true : false;
	}
	
	private function disableNotice($notice_key, $type = 'temp')
	{
		$noticePref = $this->getNoticePref();
		$noticePref[$type][$notice_key] = time();
		update_option($this->noticePrefKey, $noticePref, 'no');
		$this->pref = $noticePref;
	}
	
	public function getNoticePref()
	{
		if(!$this->pref) {
			$this->pref = get_option($this->noticePrefKey, array());
		}
		return $this->pref;
	}
	
	public function shouldShowNotice($noticeName)
	{
		$notificationPref = $this->getNoticePref();
		if(!$notificationPref) {
			return true;
		}
		if( ArrayHelper::get($notificationPref, $noticeName) ) {
			return false;
		}
		return true;
	}
	
	private function haveTempHideNotice($noticeName)
	{
		$tempHideNotices = get_option('_fluentform_temp_disable_notices');
		if($tempHideNotices && isset($tempHideNotices['$noticeName']))
		{
			$tempDisabledTime = $tempHideNotices['$noticeName'];
			$difference = time() - intval($tempDisabledTime);
			if($difference < $this->noticeDisabledTime) {
				return true;
			}
			return false;
		}

		return false;
	}
	
	private function hasPermission()
	{
		return current_user_can('fluentform_dashboard_access');
	}
}
