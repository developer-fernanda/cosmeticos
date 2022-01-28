<?php

namespace FluentForm\App\Modules;

class Deactivator
{
	/**
	 * This method will be called on plugin deactivation
	 * @return void
	 */
	public function handleDeactivation()
	{
	    self::disableCronSchedule();
	}

    public static function disableCronSchedule()
    {
        wp_clear_scheduled_hook('fluentform_do_scheduled_tasks');
        wp_clear_scheduled_hook('fluentform_do_email_report_scheduled_tasks');
    }
}