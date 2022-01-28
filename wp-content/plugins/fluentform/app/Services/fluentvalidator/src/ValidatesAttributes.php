<?php

namespace FluentValidator;

use Countable;
use InvalidArgumentException;
use FluentValidator\Contracts\File;

trait ValidatesAttributes
{
    /**
     * Require a certain number of parameters to be present.
     *
     * @param int $count
     * @param array $parameters
     * @param string $rule
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function requireParameterCount($count, $parameters, $rule)
    {
        if (count($parameters) < $count) {
            throw new InvalidArgumentException(
                "Validation rule $rule requires at least $count parameters."
            );
        }
    }

    /**
     * Get the size of an attribute.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return mixed
     */
    protected function getSize($attribute, $value)
    {
        // This method will determine if the attribute is a number, string, or file and
        // return the proper size accordingly. If it is a number, then number itself
        // is the size. If it is a file, we take kilobytes, and for a string the
        // entire length of the string will be considered the attribute size.
        $type = $this->deduceType($value);

        switch ($type) {
            case 'numeric':
                return $value;
            case 'array':
                return count($value);
            case 'file':
                return $value->getSize() / 1024;
            default:
                return mb_strlen($value);
        }
    }

    /**
     * Deduce the value type of an attribute.
     *
     * @param $value
     *
     * @return string
     */
    protected function deduceType($value)
    {
        if (is_numeric($value)) {
            return 'numeric';
        } elseif (is_array($value)) {
            return 'array';
        } elseif ($value instanceof File) {
            return 'file';
        }

        return 'string';
    }

    /**
     * Convert the given values to boolean if they are string "true" / "false".
     *
     * @param array $values
     *
     * @return array
     */
    protected function convertValuesToBoolean($values)
    {
        return array_map(function ($value) {
            if ($value === 'true') {
                return true;
            } elseif ($value === 'false') {
                return false;
            }

            return $value;
        }, $values);
    }

    /**
     * Validate that a required attribute exists.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    protected function validateRequired($attribute, $value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        } elseif ((is_array($value) || $value instanceof Countable) && count($value) < 1) {
            return false;
        } elseif ($value instanceof File) {
            return (string) $value->getPath() != '';
        }

        return true;
    }

    /**
     * Validate that an attribute exists when another attribute has a given value.
     *
     * @param string $attribute
     * @param mixed $value
     * @param mixed $parameters
     *
     * @return bool
     */
    protected function validateRequiredIf($attribute, $value, $parameters)
    {
        $this->requireParameterCount(2, $parameters, 'required_if');

        $other = Arr::get($this->data, $parameters[0]);

        $values = array_slice($parameters, 1);

        if (is_bool($other)) {
            $values = $this->convertValuesToBoolean($values);
        }

        if (in_array($other, $values)) {
            return $this->validateRequired($attribute, $value);
        }

        return true;
    }

    /**
     * Validate that an attribute is a valid e-mail address.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    protected function validateEmail($attribute, $value)
    {
        return ! ! is_email($value);
    }

    /**
     * Validate the size of an attribute.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     *
     * @return bool
     */
    protected function validateSize($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'size');

        return $this->getSize($attribute, $value) == $parameters[0];
    }

    /**
     * Validate the size of an attribute is greater than a minimum value.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     *
     * @return bool
     */
    protected function validateMin($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'min');

        return $this->getSize($attribute, $value) >= $parameters[0];
    }

    /**
     * Validate the size of an attribute is less than a maximum value.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     *
     * @return bool
     */
    protected function validateMax($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'max');

        return $this->getSize($attribute, $value) <= $parameters[0];
    }

    /**
     * Validate that two attributes match.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     *
     * @return bool
     */
    protected function validateSame($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'same');

        $other = @$this->data[$parameters[0]];

        return $value === $other;
    }

    /**
     * Validate that an attribute is a valid URL.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    protected function validateUrl($attribute, $value)
    {
        $result = (bool) filter_var($value, FILTER_VALIDATE_URL);
        return apply_filters('fluentform_url_validator', $result, $value);
    }

    /**
     * Validate that an attribute is numeric.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    protected function validateNumeric($attribute, $value)
    {
        return is_numeric($value);
    }

    /**
     * Validate the guessed extension of a file upload is in a set of file extensions.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     *
     * @return bool
     */
    protected function validateMimes($attribute, $value, $parameters)
    {
        if (! $this->isValidFileInstance($value)) {
            return false;
        }

        if ($this->shouldBlockPhpUpload($value, $parameters)) {
            return false;
        }

        /**
         * @var $value \FluentForm\Framework\Request\File
         */
        return $value->getPath() != '' && in_array($value->guessExtension(), $parameters);
    }

    /**
     * Check that the given value is a valid file instance.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValidFileInstance($value)
    {
        return $value instanceof File && $value->isValid();
    }

    /**
     * Check if PHP uploads are explicitly allowed.
     *
     * @param mixed $value
     * @param array $parameters
     *
     * @return bool
     */
    protected function shouldBlockPhpUpload($value, $parameters)
    {
        if (in_array('php', $parameters)) {
            return false;
        }

        return strtolower($value->getClientOriginalExtension()) === 'php';
    }

    /**
     * Validate that an attribute exists even if not filled.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    protected function validatePresent($attribute, $value)
    {
        return Arr::has($this->data, $attribute);
    }
}