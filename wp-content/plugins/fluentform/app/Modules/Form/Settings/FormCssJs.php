<?php

namespace FluentForm\App\Modules\Form\Settings;

use FluentForm\App\Helpers\Helper;

class FormCssJs
{
    public function addCssJs($formId)
    {
        // @todo: Limit 3 sometimes make things double
        $metas = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->whereIn('meta_key', [
                '_custom_form_css',
                '_custom_form_js',
                '_ff_form_styler_css'
            ])
            ->groupBy('meta_key')
            //->limit(3)
            ->get();

        if (!$metas) {
            return;
        }


        foreach ($metas as $meta) {
            if ($meta->meta_key == '_custom_form_css' && $meta->value) {
                $css = $meta->value;
                $css = str_replace('{form_id}', $formId, $css);
                $css = str_replace('FF_ID', $formId, $css);
                $this->addCss($formId, $css, 'fluentform_custom_css_'.$formId );
            } else if(($meta->meta_key == '_ff_form_styler_css' && $meta->value)) {
                $css = $meta->value;
                $this->addCss($formId, $css, 'fluentform_styler_css_'.$formId );
            } else if ($meta->meta_key == '_custom_form_js' && $meta->value) {
                $this->addJs($formId, $meta->value);
            }
        }
    }

    public function getCss($formId)
    {
        $cssMeta = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', '_custom_form_css')
            ->first();

        if(!$cssMeta || !$cssMeta->value) {
            return '';
        }

        $css = $cssMeta->value;
        $css = str_replace('{form_id}', $formId, $css);
        $css = str_replace('FF_ID', $formId, $css);
        return $this->escCss($css);
    }

    public function getJs($formId)
    {
        $jsMeta = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', '_custom_form_js')
            ->first();

        if(!$jsMeta || !$jsMeta->value) {
            return '';
        }
        
        return $jsMeta->value;
    }

    public function addCss($formId, $css, $cssId = 'fluentform_custom_css')
    {
        if ($css) {
            if (!did_action('wp_head')) {
                add_action('wp_head', function () use ($css, $formId, $cssId) {
                    ?>

<style id="<?php echo esc_attr($cssId); ?>" type="text/css">
    <?php echo $this->escCss($css); ?>
</style>
                    <?php
                }, 10);
            } else {
                ?>

    <style id="<?php echo esc_attr($cssId); ?>" type="text/css">
        <?php echo $this->escCss($css); ?>
    </style>
                <?php
            }
        }
    }

    public function addJs($formId, $customJS)
    {
        if (trim($customJS)) {
            add_action('wp_footer', function () use ($formId, $customJS) {
                ?>
                <script type="text/javascript">
                    jQuery(document.body).on('fluentform_init_<?php echo $formId; ?>', function (event, data) {
                        var $form = jQuery(data[0]);
                        var formId = "<?php echo $formId; ?>";
                        var $ = jQuery;
                        try {
                            <?php echo $customJS; ?>
                        } catch (e) {
                            console.warn('Error in custom JS of Fluentform ID: ' + $form.data('form_id'));
                            console.error(e);
                        }
                    });
                </script>
                <?php
            }, 100);
        }
    }

    /**
     * Get settings for a particular form by id
     * @return void
     */
    public function getSettingsAjax()
    {
        $formId = absint($_REQUEST['form_id']);
        wp_send_json_success(array(
            'custom_css' => $this->getData($formId, '_custom_form_css'),
            'custom_js'  => $this->getData($formId, '_custom_form_js'),
        ), 200);
    }

    /**
     * Save settings for a particular form by id
     * @return void
     */
    public function saveSettingsAjax()
    {
        $formId = absint($_REQUEST['form_id']);

        $css = wp_strip_all_tags(wp_unslash($_REQUEST['custom_css']));
        $js = wp_unslash($_REQUEST['custom_js']);

        if (preg_match('#</?\w+#', $css)) {
	        $css = '';
        }

        $this->store($formId, '_custom_form_css', $css);
        $this->store($formId, '_custom_form_js', $js);

        wp_send_json_success([
            'message' => __('Custom CSS and JS successfully updated', 'fluentform')
        ], 200);
    }

	protected function escCss($css)
	{
        return preg_match('#</?\w+#', $css) ? '' : $css;
    }


    protected function getData($formId, $metaKey)
    {
        $row = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', $metaKey)
            ->first();
        if ($row) {
            return $row->value;
        }
        return '';
    }


    protected function store($formId, $metaKey, $metaValue)
    {
        $row = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', $metaKey)
            ->first();

        if (!$row) {
            return wpFluent()->table('fluentform_form_meta')
                ->insert([
                    'form_id'  => $formId,
                    'meta_key' => $metaKey,
                    'value'    => $metaValue
                ]);
        }

        return wpFluent()->table('fluentform_form_meta')
            ->where('id', $row->id)
            ->update([
                'value' => $metaValue
            ]);
    }
}
