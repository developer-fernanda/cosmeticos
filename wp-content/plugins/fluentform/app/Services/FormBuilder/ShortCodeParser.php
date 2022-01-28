<?php

namespace FluentForm\App\Services\FormBuilder;

use FluentForm\App;
use FluentForm\App\Modules\Form\FormDataParser;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\Browser\Browser;
use FluentForm\Framework\Helpers\ArrayHelper;

class ShortCodeParser
{
    protected static $form = null;

    protected static $entry = null;

    protected static $browser = null;

    protected static $formFields = null;

    protected static $store = [
        'inputs'          => null,
        'original_inputs' => null,
        'user'            => null,
        'post'            => null,
        'other'           => null,
        'submission'      => null
    ];

    public static function parse($parsable, $entryId, $data = [], $form = null, $isUrl = false, $provider = false)
    {
        try {
            static::setDependencies($entryId, $data, $form);

            if (is_array($parsable)) {
                return static::parseShortCodeFromArray($parsable, $isUrl, $provider);
            }

            return static::parseShortCodeFromString($parsable, $isUrl, false);

        } catch (\Exception $e) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log($e->getTraceAsString());
            }
            return '';
        }
    }

    protected static function setDependencies($entry, $data, $form)
    {
        static::setEntry($entry);
        static::setData($data);
        static::setForm($form);
    }

    protected static function setEntry($entry)
    {
        static::$entry = $entry;
    }

    protected static function setdata($data)
    {
        if (!is_null($data)) {
            static::$store['inputs'] = $data;
            static::$store['original_inputs'] = $data;
        } else {
            $data = json_decode(static::getEntry()->response, true);
            static::$store['inputs'] = $data;
            static::$store['original_inputs'] = $data;
        }
    }

    protected static function setForm($form)
    {
        if (!is_null($form)) {
            static::$form = $form;
        } else {
            static::$form = static::getEntry()->form_id;
        }
    }

    protected static function parseShortCodeFromArray($parsable, $isUrl = false, $provider = false)
    {
        foreach ($parsable as $key => $value) {
            if (is_array($value)) {
                $parsable[$key] = static::parseShortCodeFromArray($value, $isUrl, $provider);
            } else {
                $isHtml = false;
                if ($provider) {
                    $isHtml = apply_filters('ff_will_return_html', false, $provider, $key);
                }
                $parsable[$key] = static::parseShortCodeFromString($value, $isUrl, $isHtml);
            }
        }

        return $parsable;
    }

    protected static function parseShortCodeFromString($parsable, $isUrl = false, $isHtml = false)
    {
        if (!$parsable) {
            return '';
        }
        return preg_replace_callback('/{+(.*?)}/', function ($matches) use ($isUrl, $isHtml) {
            $value = '';
            if (strpos($matches[1], 'inputs.') !== false) {
                $formProperty = substr($matches[1], strlen('inputs.'));
                $value = static::getFormData($formProperty, $isHtml);
            } elseif (strpos($matches[1], 'user.') !== false) {
                $userProperty = substr($matches[1], strlen('user.'));
                $value = static::getUserData($userProperty);
            } elseif (strpos($matches[1], 'embed_post.') !== false) {
                $postProperty = substr($matches[1], strlen('embed_post.'));
                $value = static::getPostData($postProperty);
            } elseif (strpos($matches[1], 'wp.') !== false) {
                $wpProperty = substr($matches[1], strlen('wp.'));
                $value = static::getWPData($wpProperty);
            } elseif (strpos($matches[1], 'submission.') !== false) {
                $submissionProperty = substr($matches[1], strlen('submission.'));
                $value = static::getSubmissionData($submissionProperty);
            } elseif (strpos($matches[1], 'cookie.') !== false) {
                $scookieProperty = substr($matches[1], strlen('cookie.'));
                $value = ArrayHelper::get($_COOKIE, $scookieProperty);
            } elseif (strpos($matches[1], 'payment.') !== false) {
                $property = substr($matches[1], strlen('payment.'));
                $value = apply_filters('fluentform_payment_smartcode', '', $property, self::getInstance());
            } else {
                $value = static::getOtherData($matches[1]);
            }

            if (is_array($value)) {
                $value = fluentImplodeRecursive(', ', $value);
            }

            if ($isUrl) {
                $value = urlencode($value);
            }

            return $value;

        }, $parsable);
    }

    protected static function getFormData($key, $isHtml = false)
    {
        if (strpos($key, '.label')) {
            $key = str_replace('.label', '', $key);
            $isHtml = true;
        }

        if (strpos($key, '.value')) {
            $key = str_replace('.value', '', $key);
            return ArrayHelper::get(static::$store['original_inputs'], $key);
        }

        if (strpos($key, '.') && !isset(static::$store['inputs'][$key])) {
            return ArrayHelper::get(
                static::$store['original_inputs'], $key, ''
            );
        }

        if (!isset(static::$store['inputs'][$key])) {
            static::$store['inputs'][$key] = ArrayHelper::get(
                static::$store['inputs'], $key, ''
            );
        }

        if (is_null(static::$formFields)) {
            static::$formFields = FormFieldsParser::getShortCodeInputs(
                static::getForm(), ['admin_label', 'attributes', 'options', 'raw']
            );
        }

        $field = ArrayHelper::get(static::$formFields, $key, '');


        if (!$field) return '';

        if ($isHtml) {
            return apply_filters(
                'fluentform_response_render_' . $field['element'],
                static::$store['original_inputs'][$key],
                $field,
                static::getForm()->id,
                $isHtml
            );
        }

        return static::$store['inputs'][$key] = apply_filters(
            'fluentform_response_render_' . $field['element'],
            static::$store['inputs'][$key],
            $field,
            static::getForm()->id,
            $isHtml
        );
    }

    protected static function getUserData($key)
    {
        if (is_null(static::$store['user'])) {
            static::$store['user'] = wp_get_current_user();
        }
        return static::$store['user']->{$key};
    }

    protected static function getPostData($key)
    {
        if (is_null(static::$store['post'])) {
            $postId = static::$store['inputs']['__fluent_form_embded_post_id'];
            static::$store['post'] = get_post($postId);
            static::$store['post']->permalink = get_the_permalink(static::$store['post']);
        }

        if (strpos($key, 'author.') !== false) {
            $authorProperty = substr($key, strlen('author.'));
            $authorId = static::$store['post']->post_author;
            if ($authorId) {
                $data = get_the_author_meta($authorProperty, $authorId);
                if (!is_array($data)) {
                    return $data;
                }
            }
            return '';
        } else if (strpos($key, 'meta.') !== false) {
            $metaKey = substr($key, strlen('meta.'));
            $postId = static::$store['post']->ID;
            $data = get_post_meta($postId, $metaKey, true);
            if (!is_array($data)) {
                return $data;
            }
            return '';
        } else if (strpos($key, 'acf.') !== false) {
            $metaKey = substr($key, strlen('acf.'));
            $postId = static::$store['post']->ID;
            if (function_exists('get_field')) {
                $data = get_field($metaKey, $postId, true);
                if (!is_array($data)) {
                    return $data;
                }
                return '';
            }
        }

        return static::$store['post']->{$key};
    }

    protected static function getWPData($key)
    {
        if ($key == 'admin_email') {
            return get_option('admin_email');
        }
        if ($key == 'site_url') {
            return site_url();
        }
        if ($key == 'site_title') {
            return get_option('blogname');
        }
        return $key;
    }

    protected static function getSubmissionData($key)
    {
        $entry = static::getEntry();

        if(empty($entry->id)) {
            return  '';
        }

        if (property_exists($entry, $key)) {
            if ($key == 'total_paid' || $key == 'payment_total') {
                return round($entry->{$key} / 100, 2);
            }
            if ($key == 'payment_method' && $key == 'test') {
                return __('Offline', 'fluentform');
            }
            return $entry->{$key};
        }
        if ($key == 'admin_view_url') {
            return admin_url('admin.php?page=fluent_forms&route=entries&form_id=' . $entry->form_id . '#/entries/' . $entry->id);
        } else if (strpos($key, 'meta.') !== false) {
            $metaKey = substr($key, strlen('meta.'));
            $data = App\Helpers\Helper::getSubmissionMeta($entry->id, $metaKey);
            if (!is_array($data)) {
                return $data;
            }
            return '';
        }

        return '';
    }

    protected static function getOtherData($key)
    {
        if (strpos($key, 'date.') === 0) {
            $format = str_replace('date.', '', $key);
            return date($format, strtotime(current_time('mysql')));
        } elseif ($key == 'admin_email') {
            return get_option('admin_email', false);
        } elseif ($key == 'ip') {
            return static::getRequest()->getIp();
        } elseif ($key == 'browser.platform') {
            return static::getUserAgent()->getPlatform();
        } elseif ($key == 'browser.name') {
            return static::getUserAgent()->getBrowser();
        } elseif ($key == 'all_data') {
            $formFields = FormFieldsParser::getEntryInputs(static::getForm());
            $inputLabels = FormFieldsParser::getAdminLabels(static::getForm(), $formFields);
            $response = FormDataParser::parseFormSubmission(static::getEntry(), static::getForm(), $formFields, true);

            $html = '<table class="ff_all_data" width="600" cellpadding="0" cellspacing="0"><tbody>';
            foreach ($inputLabels as $key => $label) {
                if (array_key_exists($key, $response->user_inputs) && ArrayHelper::get($response->user_inputs, $key)) {
                    $data = ArrayHelper::get($response->user_inputs, $key);
                    if (is_array($data) || is_object($data)) {
                        continue;
                    }
                    $html .= '<tr class="field-label"><th style="padding: 6px 12px; background-color: #f8f8f8; text-align: left;"><strong>' . $label . '</strong></th></tr><tr class="field-value"><td style="padding: 6px 12px 12px 12px;">' . $data . '</td></tr>';
                }
            }
            $html .= '</tbody></table>';
            apply_filters('fluentform_all_data_shortcode_html', $html, $formFields, $inputLabels, $response);
            return $html;
        }

        $groups = explode('.', $key);
        if(count($groups) > 1) {
            $group = array_shift($groups);
            $property = implode('.', $groups);
            $handlerValue = apply_filters('fluentform_smartcode_group_'.$group, $property, self::getInstance());
            if($handlerValue != $property) {
                return $handlerValue;
            }
        }

        // This fallback actually
        $handlerValue = apply_filters('fluentform_shortcode_parser_callback_' . $key, '{' . $key . '}', self::getInstance());

        if ($handlerValue) {
            return $handlerValue;
        }
        return '';
    }

    public static function getForm()
    {
        if (!is_object(static::$form)) {
            static::$form = wpFluent()->table('fluentform_forms')->find(static::$form);
        }

        return static::$form;
    }

    public static function getEntry()
    {
        if (!is_object(static::$entry)) {
            static::$entry = wpFluent()->table('fluentform_submissions')->find(static::$entry);
        }

        return static::$entry;
    }

    protected static function getRequest()
    {
        return App::make('request');
    }

    protected static function getUserAgent()
    {
        if (is_null(static::$browser)) {
            static::$browser = new Browser();
        }
        return static::$browser;
    }

    public static function getInstance()
    {
        static $instance;
        if ($instance) {
            return $instance;
        }
        $instance = new static();
        return $instance;
    }

    public static function getInputs()
    {
        return static::$store['original_inputs'];
    }

    public static function resetData()
    {
        self::$form = null;
        self::$entry = null;
        self::$browser = null;
        self::$formFields = null;

        FormFieldsParser::resetData();
        FormDataParser::resetData();
    }
}

