<?php

namespace FluentForm\App\Services\WPAsync;

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Form\FormDataParser;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\Framework\Foundation\Application;

class FluentFormAsyncRequest
{
    /**
     * $prefix The prefix for the identifier
     * @var string
     */
    protected $table = 'ff_scheduled_actions';

    /**
     * $action The action for the identifier
     * @var string
     */
    protected $action = 'fluentform_background_process';

    /**
     * $actions Actions to be fired when an async request is sent
     * @var array
     */
    protected $actions = array();

    /**
     * $app Instance of Application/Framework
     * @var FluentForm\Framework\Foundation\Application
     */
    protected $app = null;

    /**
     * Construct the Object
     * @param FluentForm\Framework\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function queueFeeds($feeds)
    {
        return wpFluent()->table($this->table)
            ->insert($feeds);
    }

    public function dispatchAjax($data = [])
    {
        $args = array(
            'timeout' => 0.1,
            'blocking' => false,
            'body' => $data,
            'cookies' => $_COOKIE,
            'sslverify' => apply_filters('fluentform_https_local_ssl_verify', false),
        );

        $queryArgs = array(
            'action' => $this->action,
            'nonce' => wp_create_nonce($this->action),
        );

        $url = add_query_arg($queryArgs, admin_url( 'admin-ajax.php' ));
        wp_remote_post(esc_url_raw($url), $args);
    }

    public function handleBackgroundCall()
    {
        $originId = false;
        if(isset($_REQUEST['origin_id'])) {
            $originId = intval($_REQUEST['origin_id']);
        }

        $this->processActions($originId);
        echo 'success';
        die();
    }

    public function processActions($originId = false)
    {
        $actionFeedQuery = wpFluent()->table($this->table)
                            ->where('status', 'pending');
        if($originId) {
            $actionFeedQuery = $actionFeedQuery->where('origin_id', $originId);
        }

        $actionFeeds = $actionFeedQuery->get();

        if(!$actionFeeds) {
            return;
        }

        $formCache = [];
        $submissionCache = [];
        $entryCache = [];

        foreach ($actionFeeds as $actionFeed) {
            $action = $actionFeed->action;
            $feed = maybe_unserialize($actionFeed->data);
            $feed['scheduled_action_id'] = $actionFeed->id;
            if(isset($submissionCache[$actionFeed->origin_id])) {
                $submission = $submissionCache[$actionFeed->origin_id];
            } else {
                $submission = wpFluent()->table('fluentform_submissions')->find($actionFeed->origin_id);
                $submissionCache[$submission->id] = $submission;
            }
            if(isset($formCache[$submission->form_id])) {
                $form = $formCache[$submission->form_id];
            } else {
                $form = wpFluent()->table('fluentform_forms')->find($submission->form_id);
                $formCache[$form->id] = $form;
            }

            if(isset($entryCache[$submission->id])) {
                $entry = $entryCache[$submission->id];
            } else {
                $entry = $this->getEntry($submission, $form);
                $entryCache[$submission->id] = $entry;
            }
            $formData = json_decode($submission->response, true);

            wpFluent()->table($this->table)
                ->where('id', $actionFeed->id)
                ->update([
                    'status' => 'processing',
                    'retry_count' => $actionFeed->retry_count + 1,
                    'updated_at' => current_time('mysql')
                ]);

            do_action($action, $feed, $formData, $entry, $form);
        }

        if($originId && !empty($form) && !empty($submission)) {
            do_action('fluentform_global_notify_completed', $submission->id, $form);
        }
    }

    private function getEntry($submission, $form)
    {
        $formInputs = FormFieldsParser::getEntryInputs($form, ['admin_label', 'raw']);
        return FormDataParser::parseFormEntry($submission, $form, $formInputs);
    }
}