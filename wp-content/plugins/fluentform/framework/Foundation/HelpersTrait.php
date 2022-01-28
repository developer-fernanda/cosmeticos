<?php

namespace FluentForm\Framework\Foundation;

trait HelpersTrait
{
    /**
     * $hookReference Current action reference
     * @var null
     */
    protected $hookReference = null;

    /**
     * Load a file using include_once
     * @return boolean
     */
    public function load($file)
    {
        $app = $this;
        return include $file;
    }

	/**
	 * Checks if the user is on wp-admin area (visiting backend)
	 * (It doesn't check whether user is authenticated ro not)
	 * @return boolean
	 */
	public function isUserOnAdminArea()
	{
		return is_admin();
	}

	/**
	 * Application's callbacks parser
	 * @param  mixed $args
	 * @return mixed
	 */
	public function parseHandler($args)
    {
        $args = is_array($args) ? $args : func_get_args();

        if (is_callable($args[0])) {
            return $args[0];
        } elseif (is_string($args[0])) {
            if (strpos($args[0], '@')) {
                list($class, $method) = explode('@', $args[0]);
                $instance = $this->make($class);
                return [$instance, $method];
            } elseif (strpos($args[0], '::')) {
                list($class, $method) = explode('::', $args[0]);
                return [$class, $method];
            } elseif (isset($args[1]) && is_string($args[1])) {
            	return $args;
            }
        } else {
            return $args;
        }
    }

    /**
     * Make a unique key/hook with the application slug prefix
     * @param  string $tag
     * @param  string $prefix [optional prefix instead of app slug]
     * @return string
     */
    public function makeKey($tag, $prefix = null)
    {
        return ($prefix ? $prefix : $this->getSlug()).'_'.$tag;
    }

    /**
     * Add/Register an ajax action
     * @param string $tag [action name]
     * @param mixed $handler
     * @param integer $priority [optional]
     * @param string $scope [specify the scope of the ajax action|internal use]
     * @return Framework\Foundation\HookReference
     */
    private function addAjaxAction($tag, $handler, $priority, $scope)
    {
    	if ($scope == 'admin') {
        	add_action(
        		'wp_ajax_'.$tag,
        		$ref = $this->parseHandler($handler),
        		$priority
        	);
    	}

    	if ($scope == 'public') {
        	add_action(
        		'wp_ajax_nopriv_'.$tag,
        		$ref = $this->parseHandler($handler),
        		$priority
        	);
    	}

        return $this->setHookReference($ref, $tag);
    }

    /**
     * Add an ajax action for authenticated user
     * @param string $tag [action name]
     * @param mixed $handler
     * @param integer $priority [optional]
     * @return mixed [a reference to the handler to remove the action later]
     */
    public function addAdminAjaxAction($tag, $handler, $priority = 10)
    {
        return $this->addAjaxAction($tag, $handler, $priority, 'admin');
    }

    /**
     * Add an ajax action for unauthenticated user
     * @param string $tag [action name]
     * @param mixed $handler
     * @param integer $priority [optional]
     * @return mixed [a reference to the handler to remove the action later]
     */
    public function addPublicAjaxAction($tag, $handler, $priority = 10)
    {
        return $this->addAjaxAction($tag, $handler, $priority, 'public');
    }

    /**
     * Remove/Unregister a registered ajax action
     * @param string $tag [action name]
     * @param mixed $handler [previously stored reference when added the action]
     * @param integer $priority [optional]
     * @param string $scope [specify the scope of the ajax action|internal use]
     * @return mixed [a reference to the handler to remove the action later]
     */
    private function removeAjaxAction($tag, $handler, $priority, $scope)
    {
    	if ($scope == 'admin') {
        	return remove_action(
        		'wp_ajax_'.$tag,
        		$this->parseHandler($handler),
        		$priority
        	);
    	}

    	if ($scope == 'public') {
        	return remove_action(
        		'wp_ajax_no_priv_'.$tag,
        		$this->parseHandler($handler),
        		$priority
        	);
    	}
    }

    /**
     * Remove an ajax action for authenticated user
     * @param string $tag [action name]
     * @param mixed $handler [previously stored reference when added the action]
     * @param integer $priority [optional]
     * @return bool [true on success or false on failure]
     */
    public function removeAdminAjaxAction($tag, $handler, $priority = 10)
    {
        return $this->removeAjaxAction($tag, $handler, $priority, 'admin');
    }

    /**
     * Remove an ajax action for unauthenticated user
     * @param string $tag [action name]
     * @param mixed $handler [previously stored reference when added the action]
     * @param integer $priority [optional]
     * @return bool [true on success or false on failure]
     */
    public function removePublicAjaxAction($tag, $handler, $priority = 10)
    {
        return $this->removeAjaxAction($tag, $handler, $priority, 'public');
    }


    /**
     * Add WordPress Filter
     * @param  string $tag
     * @param  mixed $handler
     * @param  integer $priority
     * @param  integer $acceptedArgs
     * @return Framework\Foundation\HookReference
     */
    public function addFilter($tag, $handler, $priority = 10, $acceptedArgs = 1)
    {
        add_filter(
            $tag,
            $ref = $this->parseHandler($handler),
            $priority,
            $acceptedArgs
        );

        return $this->setHookReference($ref, $tag);
    }

    /**
     * Remove WordPress Filter.
     * @param  string $tag
     * @param  mixed  $handler
     * @param  integer $priority
     * @return true
     */
    public function removeFilter($tag, $handler, $priority = 10)
    {
        return remove_filter(
            $tag,
            $this->parseHandler($handler),
            $priority
        );
    }

    /**
     * Remove WordPress' All Filters.
     * @param  string $tag
     * @param  boolean $priority
     * @return bool
     */
    public function removeFilters($tag, $priority = false)
    {
        return remove_all_filters($tag, $priority);
    }

    /**
     * Apply WordPress Filter.
     * @return mixed [filtered content]
     */
    public function applyFilters()
    {
        return call_user_func_array('apply_filters', func_get_args());
    }

    /**
     * Add WordPress Action
     * @param  string $tag
     * @param  mixed $handler
     * @param  integer $priority
     * @param  integer $acceptedArgs
     * @return Framework\Foundation\HookReference
     */
    public function addAction($tag, $handler, $priority = 10, $acceptedArgs = 1)
    {
        add_action(
            $tag,
            $ref = $this->parseHandler($handler),
            $priority,
            $acceptedArgs
        );

        return $this->setHookReference($ref, $tag);
    }

    /**
     * Remove WordPress' Action.
     * @param  string $tag
     * @param  boolean $priority
     * @return bool
     */
    public function removeAction($tag, $handler, $priority = 10)
    {
        return remove_action(
            $tag,
            $this->parseHandler($handler),
            $priority
        );
    }

    /**
     * Remove WordPress' All Actions.
     * @param  string $tag
     * @param  boolean $priority
     * @return bool
     */
    public function removeActions($tag, $priority = false)
    {
        return remove_all_actions($tag, $priority);
    }

    /**
     * Do WordPress Action.
     * @return void
     */
    public function doAction()
    {
        call_user_func_array('do_action', func_get_args());
    }

    /**
     * Add WordPress Short Code.
     * @param string $tag
     * @param mixed $handler
     */
    public function addShortCode($tag, $handler)
    {
        add_shortcode(
            $tag,
            $this->parseHandler($handler)
        );
    }

    /**
     * Remove WordPress Short Code.
     * @param string $content
     * @param bool $ignoreHtml
     */
    public function removeShortCode($tag)
    {
        remove_shortcode($tag);
    }

    /**
     * Do WordPress Short Code.
     * @param string $content
     * @param bool $ignoreHtml
     */
    public function doShortCode($tag, $atts, $content = null, $ignoreHtml = false)
    {
        return do_shortcode(
            $this->formatShortCode($tag, $atts, $content), $ignoreHtml
        );
    }

    /**
     * Format the short content (make shortcode content string)
     * @param  string $tag
     * @param  array $atts
     * @param  string $content
     * @return string
     */
    public function formatShortCode($tag, $atts, $content = null)
    {
        $str = '';
        foreach ($atts as $key => $value) {
            $str .= " {$key}={$value}";
        }
        return "[{$tag}{$str}]{$content}[/{$tag}]";
    }

    /**
     * Store a reference of last action handler
     * @param reference $ref (Reference of registered function/handler)
     * @param string $tag
     * @return $this
     */
    public function setHookReference($ref, $tag)
    {
        $this->hookReference = new HookReference($this, $ref, $tag);

        return $this;
    }

    /**
     * Save the hook's handler reference
     * @param  string $key
     * @return reference
     */
    public function saveReference($key = null)
    {
        if (!is_null($this->hookReference)) {
            $this->hookReference->saveReference($key);
            $this->hookReference = null;
            return $this;
        }

        throw new \Exception(
            'No reference is available. Call this method only after you add any action/filter/ajax hook.'
        );
    }

    /**
     * Register any callback/middleware to run before ajax callback
     * @param  string $actionName
     * @param  mixed $fn (WordPress permission name/closure)
     * @return $this
     */
    public function before($action, $fn)
    {
        $this->bindInstance("__ajax_before__{$action}", is_callable($fn) ? $fn : function() use ($fn) {
            if (!current_user_can($fn)) {
                wp_send_json_error(array(
                    'message' => "You don't have permission for this."
                ), 403);
            }
        });

        return $this;
    }
}
