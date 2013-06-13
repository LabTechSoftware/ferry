<?php namespace Labtech\Ferry\Soap;

use Labtech\Ferry\FerryException,
    Labtech\Ferry\Result;

/**
 * SOAP Results
 *
 * @package Ferry
 * @category SOAP
 **/
class SoapResult extends Result
{
    /**
     * Test/add a result from an soap call response object
     *
     * @throws FerryException
     * @param object $resObject
     * @param string $expected
     * @return void
     */
    public static function addResultFromObject($resObject, $expected = null)
    {
        if (is_object($resObject) === false)
        {
            throw new FerryException('Cannot extract result from non object.');
        }

        if (is_null($expected) === false)
        {
            // Method or property exists?
            if (method_exists($resObject, $expected) === true OR property_exists($resObject, $expected) === true)
            {
                // Add the method/property result
                static::addResult($resObject->$expected);
            }
            else
            {
                // Property/method does not exist, add the object itself
                static::addResult($resObject);

                // throw new FerryException('Expected result ('.$expected.') does not exist in result object.');
            }    
        }
        else
        {
            // Only passed an object, no expected method/property
            static::addResult($resObject);
        }
    }
}