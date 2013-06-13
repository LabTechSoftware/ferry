<?php namespace Labtech\Ferry;

use stdClass,
    Labtech\Ferry\FerryException;

/**
 * Request Params Container
 *
 * @package Ferry
 */
class RequestParams
{
    public static $params = array();

    /**
     * Set a parameter 
     *
     * @param mixed (string/integer) $key
     * @param mixed
     * @return void
     */
    public static function set($key, $value)
    {
        if (array_key_exists($key, static::$params) === true)
        {
            if (is_array(static::$params[$key]) === true)
            {
                if (is_array($value) === true)
                {
                    $mergedParams = array_merge($value, static::$params[$key]);
                    static::$params[$key] = $mergedParams;
                }
                else
                {
                    array_push(static::$params[$key], $value);
                }
            }
            elseif (is_string(static::$params[$key]) === true)
            {
                static::$params[$key] .= $value;
            }
            else
            {
                throw new FerryException('Invalid set parameter key/value.');
            }
        }
        else
        {
            static::$params[$key] = $value;
        }   
    }

    /**
     * Clear a parameter by key
     *
     * @param mixed $key
     * @return void
     **/
    public static function clear($key)
    {
        if (array_key_exists($key, static::$params) !== true)
        {
            throw new FerryException('Cannot clear parameter, key does not exist.');
        }

        unset(static::$params[$key]);
    }

    /**
     * Set multiple parameters
     *
     * @throws FerryException
     * @param array $params
     * @return void
     */
    public static function setMultiple(array $params)
    {
        if (count($params) <= 0)
        {
            throw new FerryException('Unable to set multiple request parameters with empty array.');
        }

        foreach ($params as $paramKey => $paramVal)
        {
            static::set($paramKey, $paramVal);
        }
    }

    /**
     * Get a parameter
     *
     * @throws FerryException
     * @param mixed (string/integer)
     * @return mixed
     */
    public static function get($key)
    {
        if (is_string($key) === false OR is_integer($key) === false)
        {
            throw new FerryException('Parameter key can only be a string or integer.');
        }

        if (array_key_exists($key, static::$params) !== true)
        {
            throw new FerryException('Parameter does not exist.');
        }

        return static::$params[$key];
    }

    /**
     * Get all parameters
     *
     * @return array
     */
    public static function getAll()
    {
        return static::$params;
    }

    /**
     * Get all parameters as an object (stdClass)
     *
     * @return stdClass
     */
    public static function getAllObject()
    {
        $retClass = new stdClass;

        foreach (static::getAll() as $parKey => $parVal)
        {
            $retClass->$parKey = $parVal;
        }

        return $retClass;
    }
}