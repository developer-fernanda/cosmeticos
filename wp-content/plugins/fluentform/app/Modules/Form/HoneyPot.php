<?php

namespace FluentForm\App\Modules\Form;

use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;


class HoneyPot
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    public function renderHoneyPot($form)
    {
        if (!$this->isEnabled($form->id)) {
            return;
        }
        ?>
        <span style="display: none !important;"><input type="checkbox" name="<?php echo $this->getFieldName($form->id); ?>" value="1"
               style="display:none !important;" tabindex="-1"></span>
        <?php
    }

    public function verify($insertData, $requestData, $formId)
    {
        if (!$this->isEnabled($formId)) {
            return;
        }

        // Now verify
        if (ArrayHelper::get($requestData, $this->getFieldName($formId))) {
            // It's a bot! Block him
            wp_send_json(
                array(
                    'errors' => 'Sorry! You can not submit this form at this moment!'
                ), 422);
        }

        return;
    }

    public function isEnabled($formId = false)
    {
        $option = get_option('_fluentform_global_form_settings');
        $status = ArrayHelper::get($option, 'misc.honeypotStatus') == 'yes';
        return apply_filters('fluentform_honeypot_status', $status, $formId);
    }

    private function getFieldName($formId)
    {
        return apply_filters('fluentform_honeypot_name', 'item__' . $formId . '__fluent_checkme_', $formId);
    }

}