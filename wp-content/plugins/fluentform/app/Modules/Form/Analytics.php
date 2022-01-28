<?php

namespace FluentForm\App\Modules\Form;

use FluentForm\App\Services\Browser\Browser;
use FluentForm\Framework\Foundation\Application;

class Analytics
{
	/**
     * @var \FluentForm\Framework\Foundation\Application
     */
    protected $app;

    /**
     * Build the instance
     *
     * @param \FluentForm\Framework\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

	/**
	 * Save form view analytics data
	 * 
	 * @return json respoonse
	 */
	public function record($formId)
	{
		return $this->saveViewAnalytics($formId);
	}


	public function resetFormAnalytics()
    {
        $formId = intval($_REQUEST['form_id']);
        wpFluent()
            ->table('fluentform_form_analytics')
            ->where('form_id', $formId)
            ->delete();

        wpFluent()
            ->table('fluentform_form_meta')
            ->where('meta_key', '_total_views')
            ->where('form_id', $formId)
            -> delete();

        wp_send_json_success([
            'message' => __('Form Analytics has been successfully resetted')
        ], 200);

    }

	/**
     * Save form view analytics data
     * @return void
     */
    private function saveViewAnalytics($formId)
    {
        $userId = null;
        if ($user = wp_get_current_user()) {
            $userId = $user->ID;
        }
        $browser = new Browser();
        $data = array(
            'count' => 1,
            'form_id' => $formId,
            'user_id' => $userId,
            'ip' => $this->app->request->getIp(),
            'browser' => $browser->getBrowser(),
            'platform' => $browser->getPlatform(),
            'created_at' => current_time('mysql'),
            'source_url' => $this->app->request->server('HTTP_REFERER'),
        );

        $query = wpFluent()
            ->table('fluentform_form_analytics')
            ->where('ip', $data['ip'])
            ->where('form_id', $data['form_id'])
            ->where('source_url', $data['source_url']);

        try {
            if (($record = $query->first())) {
                $query->update(array('count' => ++$record->count));
            } else {
                wpFluent()->table('fluentform_form_analytics')->insert($data);
                $this->increaseTotalViews($formId);
            }

        } catch(\Exception $e) {

        }
    }

    /**
     * Store (create/update) total view of a form
     * @param  int $formId
     * @return void
     */
    private function increaseTotalViews($formId)
    {
        // check if meta is already exists or not
        $hasCount = wpFluent()
                    ->table('fluentform_form_meta')
                    ->where('meta_key', '_total_views')
                    ->where('form_id', $formId)
                    -> first();

        if($hasCount) {
            wpFluent()
                ->table('fluentform_form_meta')
                ->where('id', $hasCount->id)
                ->update(array(
                    'value' => intval($hasCount->value) + 1
                ));
        } else {
            wpFluent()
                ->table('fluentform_form_meta')
                ->insert(array(
                    'value' => 1,
                    'form_id' => $formId,
                    'meta_key' => '_total_views'
                ));
        }
    }
}