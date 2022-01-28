<?php

namespace FluentForm\Framework\Foundation;

use Closure;
use Exception;
use ArrayAccess;
use ReflectionClass;
use ReflectionParameter;
use FluentForm\Framework\Exception\UnResolveableEntityException;

class Container implements ArrayAccess
{
    /**
     * $container The service container
     * @var array
     */
    protected static $container = array(
        'facades'    => array(),
        'aliases'    => array(),
        'resolved'   => array(),
        'bindings'   => array(),
        'singletons' => array(),
    );

    /**
     * Bind an instance into service container
     * @param string $key identifier
     * @param mixed $concrete
     * @param string $facade [optional facade]
     * @param string $alias [optional alias]
     * @return void
     */
    public function bind($key, $concrete = null, $facade = null, $alias = null, $shared = false)
    {
        $concrete = is_null($concrete) ? $key : $concrete;

        if (!$shared) {
            static::$container['bindings'][$key] = $concrete;
        } else {
            static::$container['singletons'][$key] = $concrete;
            if ($this->resolved($key)) {
                $this->clearResolved($key);
            }
        }

        if ($facade) {
            $this->facade($key, $facade);
        }

        if ($alias) {
            $this->alias($key, $alias);
        }
    }

    /**
     * Bind a singleton instance into service container
     * @param string $key identifier
     * @param mixed $concrete
     * @param string $facade [optional facade]
     * @param string $alias [optional alias]
     * @return void
     */
    public function bindSingleton($key, $concrete = null, $facade = null, $alias = null)
    {
        $this->bind($key, $concrete, $facade, $alias, true);
    }

    /**
     * Bind a singleton instance into service container
     * @param string $key identifier
     * @param mixed $concrete
     * @param string $facade [optional facade]
     * @param string $alias [optional alias]
     * @return void
     */
    public function bindInstance($key, $concrete, $facade = null, $alias = null)
    {
        $this->bind($key, function () use ($concrete) {
            return $concrete;
        }, $facade, $alias, true);
    }

    /**
     * Register a facade for a registered instance
     * @param string $key
     * @param string $facade
     * @return string
     */
    public function facade($key, $facade)
    {
        static::$container['facades'][$facade] = $key;
    }

    /**
     * Register an alias for a registered instance
     * @param string $key
     * @param string $alias
     * @return string
     */
    public function alias($key, $aliases)
    {
        foreach ((array)$aliases as $alias) {
            static::$container['aliases'][$alias] = $key;
        }
    }

    /**
     * Resolve an instance from container
     * @param string $key
     * @return mixed
     * @throws \FluentForm\Framework\Exception\UnResolveableEntityException
     */
    public function make($key = null, array $params = [])
    {
        if (is_null($key)) {
            return AppFacade::getApplication();
        }

        $key = $this->getAlias($key);

        if (isset(static::$container['resolved'][$key])) {
            return static::$container['resolved'][$key];
        }

        if (isset(static::$container['singletons'][$key])) {
            return static::$container['resolved'][$key] = $this->resolve(
                static::$container['singletons'][$key], $params
            );
        }

        if (isset(static::$container['bindings'][$key])) {
            return $this->resolve(static::$container['bindings'][$key], $params);
        }

        if ($this->classExists($key)) {
            return $this->resolve($key, $params);
        }

        throw new UnResolveableEntityException('The service [' . $key . '] doesn\'t exist.');
    }

    /**
     * Resolve an item from the container
     * @param mixed $value
     * @return mixed
     */
    protected function resolve($value, $params = [])
    {
        if ($value instanceof Closure) {
            return $value($this, $params);
        }

        return $this->build($value, $params);
    }

    /**
     * Build a concrete class with all dependencies
     * @param string $value FQN class name
     * @return mixed resolved instance
     */
    protected function build($value, $params = [])
    {
        if (is_object($value)) return $value;

        $reflector = new ReflectionClass($value);

        if (!$reflector->isInstantiable()) {
            throw new UnResolveableEntityException(
                "The [$value] is not instantiable."
            );
        }

        if (!($constructor = $reflector->getConstructor())) {
            return new $value;
        }

        $dependencies = $params ? $params : $this->resolveDependencies(
            $constructor->getParameters()
        );

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Resolve all dependencies of a single class
     * @param array $dependencies Constructor Parameters
     * @return array An array of all the resolved dependencies of one class
     */
    protected function resolveDependencies(array $dependencies)
    {
        $results = [];

        foreach ($dependencies as $dependency) {
            $results[] = $this->resolveClass($dependency);
        }

        return $results;
    }

    /**
     * Resolves a single class instance
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws Exception
     */
    protected function resolveClass(ReflectionParameter $parameter)
    {
        $types = ['bool', 'int', 'float', 'string', 'array', 'resource'];

        try {
            if ($class = $this->getParameterType($parameter)) {

                $phpVersion = phpversion();
                if (version_compare($phpVersion, '7', '>=') && version_compare($phpVersion, '7.1', '<')) {
                    if ($class instanceof \ReflectionType) {
                        $class = (string)$class;
                        return $this->make($class);
                    }
                }

                $class = $class->getName();
                if ($class && in_array($class, $types)) {
                    $class = null;
                }
            }

            if ($class) {
                return $this->make($class);
            }

            throw new Exception("The [" . $parameter->name . "] is not instantiable.");
        } catch (Exception $exception) {
            if ($parameter->isOptional()) {
                return $parameter->getDefaultValue();
            } elseif (!$class) {
                $name = $parameter->getName();
                $cls = $parameter->getDeclaringClass();
                throw new UnResolveableEntityException(
                    "The [" . $cls->name . "] is not instantiable, $" . $name . " is required."
                );
            }

            throw $exception;
        }
    }

    /**
     * Get the parameter type for the given parameter.
     *
     * @return object ReflectionClass|ReflectionNamedType
     */
    protected function getParameterType($parameter)
    {
        if (method_exists($parameter, 'getType')) {
            return $parameter->getType();
        }

        return $parameter->getClass();
    }

    /**
     * Get the alias for a key if available.
     * @param string $key
     * @return string
     */
    public function getAlias($key)
    {
        if (isset(static::$container['aliases'][$key])) {
            return static::$container['aliases'][$key];
        }

        return $key;
    }

    /**
     * Check if a given class/interface exists
     * @param string $key
     * @return bool
     */
    protected function classExists($key)
    {
        return is_string($key) && (class_exists($key) || interface_exists($key));
    }

    /**
     * Check if an item exists at a given offset
     * @param string $offset
     * @return bool
     */
    public function bound($offset)
    {
        return isset(static::$container['resolved'][$offset]) ||
            isset(static::$container['singletons'][$offset]) ||
            isset(static::$container['bindings'][$offset]);
    }

    /**
     * Check if an item exists at a given offset
     * @param string $offset
     * @return bool
     */
    public function has($offset)
    {
        return $this->bound($offset);
    }

    /**
     * Check if an item exists at a given offset
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->bound($offset);
    }

    /**
     * Get the value from given offset
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetGet($offset)
    {
        return $this->make($offset);
    }

    /**
     * Set the value at a given offset
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->bindInstance($offset, $value);
    }

    /**
     * Unset the value at a given offset
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset(
            static::$container['bindings'][$offset],
            static::$container['resolved'][$offset],
            static::$container['singletons'][$offset]
        );

        if (array_key_exists($offset, $aliases = array_flip(static::$container['aliases']))) {
            unset(static::$container['aliases'][$aliases[$offset]]);
        }

        if (array_key_exists($offset, $facades = array_flip(static::$container['facades']))) {
            unset(static::$container['facades'][$facades[$offset]]);
        }
    }

    /**
     * Determine whether a shared entity is resolved.
     * @param string $key
     * @return bool
     */
    public function resolved($key)
    {
        return array_key_exists($key, static::$container['resolved']);
    }

    /**
     * Get one or all resolved instance(s)
     * @param string $key
     * @return mixed
     */
    public function getResolved($key = null)
    {
        return static::$container['resolved'];
    }

    /**
     * Clear one or all resolved instance(s)
     * @param string $key
     * @return void
     */
    public function clearResolved($key = null)
    {
        if (!$key) {
            static::$container['resolved'] = [];
        } else {
            unset(static::$container['resolved'][$key]);
        }
    }

    /**
     * Get one or all binding(s)
     * @param string $key
     * @return void
     */
    public function getBindings($key = null)
    {
        return static::$container['bindings'];
    }

    /**
     * Clear one or all binding(s)
     * @param string $key
     * @return void
     */
    public function clearBindings($key = null)
    {
        if (!$key) {
            static::$container['bindings'] = [];
        } else {
            unset(static::$container['bindings'][$key]);
        }
    }

    /**
     * Get one or all singletons(s)
     * @param string $key
     * @return void
     */
    public function getSingletons($key = null)
    {
        return static::$container['singletons'];
    }

    /**
     * Clear one or all singletons(s)
     * @param string $key
     * @return void
     */
    public function clearSingletons($key = null)
    {
        if (!$key) {
            static::$container['singletons'] = [];
        } else {
            unset(static::$container['singletons'][$key]);
        }
    }
}