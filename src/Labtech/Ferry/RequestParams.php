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
    protected static $params = array();

    /**
     * Set a parameter 
     *
     * @throws Ferry/FerryException
     * @param mixed (string/integer) $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        // Is there a param with this key already?
        if (array_key_exists($key, self::$params) === true)
        {
            // Is the stored item an array?
            if (is_array(self::$params[$key]) === true)
            {
                // Is the new value an array?
                if (is_array($value) === true)
                {
                    // Merge new value with existing stored array items under this key
                    $mergedParams = array_merge($value, self::$params[$key]);

                    // Save merged data
                    self::$params[$key] = $mergedParams;
                }
                else
                {
                    // The new value is not an array
                    // Add the new value at the end of the stored data array
                    array_push(self::$params[$key], $value);
                }
            }
            elseif (is_string(self::$params[$key]) === true) // Is there a string already stored w/ this key?
            {
                // Overwrite what's stored already
                self::$params[$key] = $value;
            }
            else
            {
                // Unknown stored parameter
                throw new FerryException('Stored parameter is not an array or string.');
            }
        }
        else
        {
            // New param item, add key => val
            self::$params[$key] = $value;
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
        // Make sure it exists first
        if (array_key_exists($key, self::$params) === true)
        {
            // Unset
            unset(self::$params[$key]);
        }
    }

    /**
     * Set multiple parameters
     *
     * @throws Ferry\FerryException
     * @param array $params
     * @return void
     */
    public static function setMultiple(array $params)
    {
        // Make sure there is data in the params argument
        if (count($params) <= 0)
        {
            throw new FerryException('Unable to set multiple request parameters with empty array.');
        }

        // Loop through params and run each through set()
        foreach ($params as $paramKey => $paramVal)
        {
            static::set($paramKey, $paramVal);
        }
    }

    /**
     * Get a parameter
     *
     * @throws Ferry\FerryException
     * @param mixed (string/integer)
     * @return mixed
     */
    public static function get($key)
    {
        // Check value for string or integer type
        if (is_string($key) === false OR is_integer($key) === false)
        {
            throw new FerryException('Parameter key can only be a string or integer.');
        }

        // Check existence in stored params
        if (array_key_exists($key, self::$params) !== true)
        {
            throw new FerryException('Parameter does not exist.');
        }

        return self::$params[$key];
    }

    /**
     * Get all parameters
     *
     * @return array
     */
    public static function getAll()
    {
        return self::$params;
    }

    /**
     * Get all parameters as an object (stdClass)
     *
     * @return stdClass
     */
    public static function getAllObject()
    {
        $retClass = new stdClass;

        // Loop through all stored params and add in object as property = value
        foreach (static::getAll() as $parKey => $parVal)
        {
            $retClass->$parKey = $parVal;
        }

        return $retClass;
    }
}