<?php

namespace FluentForm\App\Services\FormBuilder;

use FluentForm\App\Services\Browser\Browser;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\Request;

class EditorShortcodeParser
{
    /**
     * Available dynamic short codes
     * @var null
     */
    private static $dynamicShortcodes = null;

    /**
     * mappings of methods to parse the shortcode
     * @var array
     */
    private static $handlers = [
        'ip'         => 'parseIp',
        'date.m/d/Y' => 'parseDate',
        'date.d/m/Y' => 'parseDate',

        'embed_post.ID'         => 'parsePostProperties',
        'embed_post.post_title' => 'parsePostProperties',
        'embed_post.permalink'  => 'parsePostProperties',
        'http_referer'          => 'parseWPProperties',

        'wp.admin_email' => 'parseWPProperties',
        'wp.site_url'    => 'parseWPProperties',
        'wp.site_title'  => 'parseWPProperties',

        'user.ID'           => 'parseUserProperties',
        'user.display_name' => 'parseUserProperties',
        'user.first_name'   => 'parseUserProperties',
        'user.last_name'    => 'parseUserProperties',
        'user.user_email'   => 'parseUserProperties',
        'user.user_login'   => 'parseUserProperties',

        'browser.name'     => 'parseBrowserProperties',
        'browser.platform' => 'parseBrowserProperties',

        'get.param_name'           => 'parseQueryParam',
        'random_string.param_name' =>  'parseRandomString'
    ];

    /**
     * Filter dynamic shortcodes in input value
     * @param string $value
     * @return string
     */
    public static function filter($value, $form)
    {
        if (strpos($value, '{ ') === 0) {
            // it's the css
            return $value;
        }


        if (is_null(static::$dynamicShortcodes)) {
            static::$dynamicShortcodes = fluentFormEditorShortCodes();
        }

        $filteredValue = '';

        foreach (static::parseValue($value) as $handler) {
            if (isset(static::$handlers[$handler])) {
                return call_user_func_array(
                    [__CLASS__, static::$handlers[$handler]],
                    ['{' . $handler . '}', $form]
                );
            } elseif (strpos($handler, 'get.') !== false) {
                return static::parseQueryParam($handler);
            } elseif (strpos($handler, 'random_string.') !== false) {
                return static::parseRandomString($handler);
            } else if (strpos($handler, 'user.meta.') !== false) {
                $key = substr(str_replace(['{', '}'], '', $value), 10);
                $user = wp_get_current_user();
                if ($user) {
                    $value = get_post_meta($user->ID, $key, true);
                    if (!is_array($value) && !is_object($value)) {
                        return $value;
                    }
                }
                return '';
            } else if (strpos($handler, 'user.') !== false) {
                $value = self::parseUserProperties($handler);
                if (is_array($value) || is_object($value)) {
                    return '';
                }
                return $value;
            } else if (strpos($handler, 'date.') !== false) {
                return self::parseDate($handler);
            } else if (strpos($handler, 'embed_post.meta.') !== false) {
                $key = substr(str_replace(['{', '}'], '', $value), 16);
                global $post;
                if ($post) {
                    $value = get_post_meta($post->ID, $key, true);
                    if (!is_array($value) && !is_object($value)) {
                        return $value;
                    }
                }
                return '';
            } else if (strpos($handler, 'embed_post.') !== false) {
                return self::parsePostProperties($handler, $form);
            } else if (strpos($handler, 'cookie.') !== false) {
                $scookieProperty = substr($handler, strlen('cookie.'));
                return ArrayHelper::get($_COOKIE, $scookieProperty);
            } else if (strpos($handler, 'dynamic.') !== false) {
                $dynamicKey = substr($handler, strlen('dynamic.'));
                // maybe has fallback value
                $dynamicKey = explode('|', $dynamicKey);
                $fallBack = '';
                $ref = '';
                if (count($dynamicKey) > 1) {
                    $fallBack = $dynamicKey[1];
                }
                $ref = $dynamicKey[0];

                if ($ref == 'payment_summary') {
                    return '<div class="ff_dynamic_value ff_dynamic_payment_summary" data-ref="payment_summary"><div class="ff_payment_summary"></div><div class="ff_payment_summary_fallback">' . $fallBack . '</div></div>';
                }

                return '<span class="ff_dynamic_value" data-ref="' . $ref . '" data-fallback="' . $fallBack . '">' . $fallBack . '</span>';
            } else {
                // This can be the css
                $handlerValue = apply_filters('fluentform_editor_shortcode_callback_' . $handler, '{' . $handler . '}', $form);
                // In not found then return the original please
                $filteredValue = $handlerValue;
            }
        }

        return $filteredValue;
    }

    /**
     * Parse the curly braced shortcode into array
     * @param string $value
     * @return mixed
     */
    public static function parseValue($value)
    {
        if (!is_array($value)) {
            return preg_split(
                '/{(.*?)}/',
                $value,
                null,
                PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
            );
        }

        return $value;
    }

    /**
     * Declare all parsers and must be [private] static methods
     */

    /**
     * Parse loggedin user properties
     * @param string $value
     * @return string
     */
    private static function parseUserProperties($value, $form = null)
    {
        if ($user = wp_get_current_user()) {
            $prop = substr(str_replace(['{', '}'], '', $value), 5);

            if (strpos($prop, 'meta.') !== false) {
                $metaKey = substr($prop, strlen('meta.'));
                $userId = $user->ID;
                $data = get_user_meta($userId, $metaKey, true);
                if (!is_array($data)) {
                    return $data;
                }
                return '';
            }

            return $user->{$prop};
        }

        return '';
    }

    /**
     * Parse embedded post properties
     * @param string $value
     * @return string
     */
    private static function parsePostProperties($value, $form = null)
    {
        global $post;
        if (!$post) {
            return '';
        }

        $key = $prop = substr(str_replace(['{', '}'], '', $value), 11);

        if (strpos($key, 'author.') !== false) {
            $authorProperty = substr($key, strlen('author.'));
            $authorId = $post->post_author;
            if ($authorId) {
                $data = get_the_author_meta($authorProperty, $authorId);
                if (!is_array($data)) {
                    return $data;
                }
            }
            return '';
        } else if (strpos($key, 'meta.') !== false) {
            $metaKey = substr($key, strlen('meta.'));
            $postId = $post->ID;
            $data = get_post_meta($postId, $metaKey, true);
            if (!is_array($data)) {
                return $data;
            }
            return '';
        } else if (strpos($key, 'acf.') !== false) {
            $metaKey = substr($key, strlen('acf.'));
            $postId = $post->ID;
            if (function_exists('get_field')) {
                $data = get_field($metaKey, $postId, true);
                if (!is_array($data)) {
                    return $data;
                }
                return '';
            }
        }

        if ($prop == 'permalink') {
            return htmlspecialchars(site_url(wp_unslash($_SERVER['REQUEST_URI'])));
        }

        if (property_exists($post, $prop)) {
            return $post->{$prop};
        }
        return '';
    }


    /**
     * Parse WP Properties
     * @param string $value
     * @return string
     */
    private static function parseWPProperties($value, $form = null)
    {
        if ($value == '{wp.admin_email}') {
            return get_option('admin_email');
        }
        if ($value == '{wp.site_url}') {
            return site_url();
        }
        if ($value == '{wp.site_title}') {
            return get_option('blogname');
        }
        if ($value == '{http_referer}') {
            return wp_get_referer();
        }

        return '';
    }

    /**
     * Parse browser/user-agent properties
     * @param string $value
     * @return string
     */
    private static function parseBrowserProperties($value, $form = null)
    {
        $browser = new Browser;
        if ($value == '{browser.name}') {
            return $browser->getBrowser();
        } elseif ($value == '{browser.platform}') {
            return $browser->getPlatform();
        }

        return '';
    }

    /**
     * Parse ip shortcode
     * @param string $value
     * @return string
     */
    private static function parseIp($value, $form = null)
    {
        $ip = Request::getIp();
        return $ip ? $ip : $value;
    }

    /**
     * Parse date shortcode
     * @param string $value
     * @return string
     */
    private static function parseDate($value, $form = null)
    {
        $format = substr(str_replace(['}', '{'], '', $value), 5);
        $date = date($format, strtotime(current_time('mysql')));
        return $date ? $date : '';
    }

    /**
     * Parse request query param.
     *
     * @param string $value
     * @param \stdClass $form
     * @return string
     */
    public static function parseQueryParam($value)
    {	        
        $exploded = explode('.', $value);
        $param = array_pop($exploded);
        if (!isset($_REQUEST[$param])) {
            return '';
        }
        $value = $_REQUEST[$param];
        if (is_array($value)) {
            return sanitize_textarea_field(implode(', ', $value));
        }
        return sanitize_textarea_field($value);
    }
    
    /**
     * Generate random a string with prefix
     *
     * @param $value
     * @return string
     */
    public static function parseRandomString($value)
    {
        
        $exploded = explode ('.',$value);
        $prefix =  array_pop($exploded) ;
        return $prefix.uniqid () ;
    }
}
