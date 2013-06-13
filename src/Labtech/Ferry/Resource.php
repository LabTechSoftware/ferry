<?php namespace Labtech\Ferry;

use Labtech\Ferry\FerryException;

/**
 * Resource Container Goodness
 *
 * @package Ferry
 */
class Resource
{
    /**
     * Resources go here
     *
     * @var array
     **/
    protected static $resources = array();

    /**
     * Add a class instance to the resources array
     *
     * @throws FerryException
     * @param string $key
     * @param object $classInstance
     * @return void
     */
    public static function setResource($key, $classInstance)
    {
        if (is_object($classInstance) === true)
        {
            static::$resources[$key] = $classInstance; 
            return;
        }
        
        throw new FerryException('Resources can only be objects.');
    }

    /**
     * Get a class instance from the resources array
     *
     * @throws FerryException
     * @param string $key
     * @return object
     */
    public static function getResource($key)
    {
        if (array_key_exists($key, static::$resources) === true)
        {
            return static::$resources[$key];            
        }

        throw new FerryException('Invalid resource key.');
    }

    /**
     * Run a method on a class instance stored in the resources array
     *
     * @throws FerryException
     * @param string $resourceKey
     * @param string $method
     * @param mixed $arguments
     * @return mixed
     */
    public static function run($resourceKey, $method, $arguments = null)
    {
        $objectInstance = static::getResource($resourceKey);
        
        if (method_exists($objectInstance, $method) === true)
        {
            return (is_null($arguments) === true) ? $objectInstance->$method() : $objectInstance->$method($arguments);
        }

        throw new FerryException('Method does not exist in resource.');
    }
}