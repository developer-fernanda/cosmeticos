<?php

namespace FluentForm\Framework\Request;

class Request
{
    /**
     * Handles HTTP files.
     */
    use FileHandler;

	protected $app = null;
	protected $headers = array();
	protected $server = array();
	protected $cookie = array();
	protected $json = array();
	protected $get = array();
	protected $post = array();
	protected $files = array();
	protected $request = array();
	
	public function __construct($app, $get, $post, $files)
	{
		$this->app = $app;
		$this->server = $_SERVER;
		$this->cookie = $_COOKIE;
		$this->request = array_merge(
			$this->get = $this->clean($get),
			$this->post = $this->clean($post),
            $this->files = $this->prepareFiles($files)
		);
	}

	/**
	 * Clean up the slashes from GET/POST added by WP
	 * using "wp_magic_quotes" function in load.php.
	 * 
	 * @param  array $data
	 * @return array
	 */
	public function clean($data)
	{
		return $data;
		// return stripslashes_deep($data);
	}

	/**
	 * Variable exists
	 * @param  string $key
	 * @return bool
	 */
	public function exists($key)
	{
	    if(!$this->request) {
	        return false;
        }
		return array_key_exists($key, $this->request);
	}

	/**
	 * Variable exists and has truthy value
	 * @param  string $key
	 * @return bool
	 */
	public function has($key)
	{
		return $this->exists($key) && !empty($this->request[$key]);
	}

	public function set($key, $value)
	{
		$this->request[$key] = $value;
		return $this;
	}

	public function all()
	{
		return $this->get();
	}

	public function get($key = null, $default = null)
	{
		if (!$key) {
			return $this->request;
		} else {
			return $this->exists($key) ? $this->request[$key] : $default;
		}
	}

    /**
     * Get the files from the request.
     *
     * @return array
     */
	public function files()
    {
        return $this->files;
    }

	public function query($key = null, $default = null)
	{
		return $key ? (isset($this->get[$key]) ? $this->get[$key] : $default) : $this->get;
	}

	public function post($key = null, $default = null)
	{
		return $key ? (isset($this->post[$key]) ? $this->post[$key] : $default) : $this->post;
	}

	public function only($args)
	{
		$values = [];
		$keys = is_array($args) ? $args : func_get_args();
		foreach ($keys as $key) {
			$values[$key] = $this->get($key);
		}
		return $values;
	}

	public function except($args)
	{
		$values = [];
		$keys = is_array($args) ? $args : func_get_args();
		foreach ($this->request as $key => $value) {
			if (!in_array($key, $keys)) {
				$values[$key] = $this->get($key);
			}
		}
		return $values;
	}

	public function merge(array $data = [])
	{
		$this->request = array_merge($this->request, $data);
		return $this;
	}

	/**
	 * Get user ip address
	 * @return string
	 */
	public function getIp()
   {
       // Get real visitor IP behind CloudFlare network
       if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
           $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
           $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
       }

       if(isset($_SERVER['HTTP_CLIENT_IP'])) {
           $ip = @$_SERVER['HTTP_CLIENT_IP'];
           if (filter_var($ip, FILTER_VALIDATE_IP)) {
               return $ip;
           }
       }

       // Sometimes the `HTTP_X_FORWARDED_FOR` can contain more than IPs
       $forward_ips = $this->server('HTTP_X_FORWARDED_FOR');
       if ($forward_ips) {
           $all_ips = explode(',', $forward_ips);
           foreach ($all_ips as $ip) {
               if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
                   return $ip;
               }
           }
       }

       return $_SERVER['REMOTE_ADDR'];
   }

	public function server($key = null, $default = null)
	{
		return $key ? (isset($this->server[$key]) ? $this->server[$key] : $default) : $this->server;
	}

	public function header($key = null, $default = null)
	{
		if (!$this->headers) {
			$this->headers = $this->setHeaders();
		}

		return $key ? (isset($this->headers[$key]) ? $this->headers[$key] : $default) : $this->headers;
	}

	public function cookie($key = null, $default = null)
	{
		return $key ? (isset($this->cookie[$key]) ? $this->cookie[$key] : $default) : $this->cookie;
	}

	/**
	 * Taken and modified from Symfony
	 */
	public function setHeaders()
    {
        $headers = array();
        $parameters = $this->server;
        $contentHeaders = array('CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true);
        foreach ($parameters as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $headers[substr($key, 5)] = $value;
            }
            // CONTENT_* are not prefixed with HTTP_
            elseif (isset($contentHeaders[$key])) {
                $headers[$key] = $value;
            }
        }

        if (isset($parameters['PHP_AUTH_USER'])) {
            $headers['PHP_AUTH_USER'] = $parameters['PHP_AUTH_USER'];
            $headers['PHP_AUTH_PW'] = isset($parameters['PHP_AUTH_PW']) ? $parameters['PHP_AUTH_PW'] : '';
        } else {
            /*
             * php-cgi under Apache does not pass HTTP Basic user/pass to PHP by default
             * For this workaround to work, add these lines to your .htaccess file:
             * RewriteCond %{HTTP:Authorization} ^(.+)$
             * RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
             *
             * A sample .htaccess file:
             * RewriteEngine On
             * RewriteCond %{HTTP:Authorization} ^(.+)$
             * RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
             * RewriteCond %{REQUEST_FILENAME} !-f
             * RewriteRule ^(.*)$ app.php [QSA,L]
             */

            $authorizationHeader = null;
            if (isset($parameters['HTTP_AUTHORIZATION'])) {
                $authorizationHeader = $parameters['HTTP_AUTHORIZATION'];
            } elseif (isset($parameters['REDIRECT_HTTP_AUTHORIZATION'])) {
                $authorizationHeader = $parameters['REDIRECT_HTTP_AUTHORIZATION'];
            }

            if (null !== $authorizationHeader) {
                if (0 === stripos($authorizationHeader, 'basic ')) {
                    // Decode AUTHORIZATION header into PHP_AUTH_USER and PHP_AUTH_PW when authorization header is basic
                    $exploded = explode(':', base64_decode(substr($authorizationHeader, 6)), 2);
                    if (count($exploded) == 2) {
                        list($headers['PHP_AUTH_USER'], $headers['PHP_AUTH_PW']) = $exploded;
                    }
                } elseif (empty($parameters['PHP_AUTH_DIGEST']) && (0 === stripos($authorizationHeader, 'digest '))) {
                    // In some circumstances PHP_AUTH_DIGEST needs to be set
                    $headers['PHP_AUTH_DIGEST'] = $authorizationHeader;
                    $parameters['PHP_AUTH_DIGEST'] = $authorizationHeader;
                } elseif (0 === stripos($authorizationHeader, 'bearer ')) {
                    /*
                     * XXX: Since there is no PHP_AUTH_BEARER in PHP predefined variables,
                     *      I'll just set $headers['AUTHORIZATION'] here.
                     *      http://php.net/manual/en/reserved.variables.server.php
                     */
                    $headers['AUTHORIZATION'] = $authorizationHeader;
                }
            }
        }

        if (isset($headers['AUTHORIZATION'])) {
            return $headers;
        }

        // PHP_AUTH_USER/PHP_AUTH_PW
        if (isset($headers['PHP_AUTH_USER'])) {
            $headers['AUTHORIZATION'] = 'Basic '.base64_encode($headers['PHP_AUTH_USER'].':'.$headers['PHP_AUTH_PW']);
        } elseif (isset($headers['PHP_AUTH_DIGEST'])) {
            $headers['AUTHORIZATION'] = $headers['PHP_AUTH_DIGEST'];
        }

        return $headers;
    }
}
