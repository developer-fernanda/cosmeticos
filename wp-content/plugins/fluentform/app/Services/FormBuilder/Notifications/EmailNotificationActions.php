<?php

namespace FluentForm\App\Services\FormBuilder\Notifications;

use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class EmailNotificationActions
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register()
    {
        add_filter('fluentform_notifying_async_email_notifications', '__return_false', 9);

        add_filter('fluentform_global_notification_active_types', function ($types) {
            $types['notifications'] = 'email_notifications';
            return $types;
        });

        add_action('fluentform_integration_notify_notifications', array($this, 'notify'), 10, 4);
    }

    public function notify($feed, $formData, $entry, $form)
    {
        $notifier = $this->app->make(
            'FluentForm\App\Services\FormBuilder\Notifications\EmailNotification'
        );

        $emailData = $feed['processedValues'];
        $emailAttachments = [];
        if(!empty($emailData['attachments']) && is_array($emailData['attachments'])) {
            $attachments = [];
            foreach ($emailData['attachments'] as $name) {
                $fileUrls = ArrayHelper::get($formData, $name);
                if($fileUrls && is_array($fileUrls)) {
                    foreach ($fileUrls as $url) {
                        $filePath = str_replace(
                            site_url(''),
                            wp_normalize_path( untrailingslashit( ABSPATH ) ),
                            $url
                        );
                        if(file_exists($filePath)) {
                            $attachments[] = $filePath;
                        }
                    }
                }
            }
            $emailAttachments = $attachments;
        }
        $mediaAttachments = ArrayHelper::get($emailData,'media_attachments') ;
        if(!empty($mediaAttachments) && is_array($mediaAttachments)) {
            $attachments = [];
            foreach ($mediaAttachments as $file) {
                $fileUrl = ArrayHelper::get($file, 'url');
                if($fileUrl) {
                    $filePath = str_replace(
                        site_url(''),
                        wp_normalize_path( untrailingslashit( ABSPATH ) ),
                        $fileUrl
                    );
                    if(file_exists($filePath)) {
                        $attachments[] = $filePath;
                    }
                }
            }
            $emailAttachments = array_merge($emailAttachments,$attachments);
        }


        // let others to apply attachments
        $emailAttachments = apply_filters('fluentform_email_attachments', $emailAttachments, $emailData, $formData, $entry, $form);
        if($emailAttachments) {
            $emailData['attachments'] = $emailAttachments;
        }

        $notifier->notify($emailData, $formData, $form, $entry->id);
    }
}
