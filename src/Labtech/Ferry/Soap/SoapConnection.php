<?php namespace Labtech\Ferry\Soap;

use SoapClient,
    Labtech\Ferry\ConnectionInterface,
    Labtech\Ferry\FerryException;

/**
 * SOAP Connection
 *
 * @package Ferry
 * @category SOAP
 */
class SoapConnection implements ConnectionInterface
{
    protected $connectionName = null;
    protected $address = null;
    protected $fullAddress = null;
    protected $domain = null;
    public $options = array();

    /**
     * Sets the connection name (e.g. for an API/WSDL name, etc)
     *
     * @throws FerryException
     * @param string $name
     * @return void
     **/
    public function setName($name)
    {
        if (is_string($name) === false)
        {
            throw new FerryException('Connection name must be a string.');
        }

        // Current connection name null? Replace with our new one
        if (is_null($this->connectionName) === true)
        {
            $this->connectionName = $name;
        }
        else
        {
            // If the current connection name is different than the new one, use new name
            if ($this->connectionName != $name)
            {
                $this->connectionName == $name;
            }
        }
    }

    /**
     * Get the connection name
     *
     * @throws FerryException
     * @return string
     */
    public function getName()
    {
        if (is_null($this->connectionName) === true OR strlen($this->connectionName) < 1)
        {
            throw new FerryException('A connection name has not been set.');
        }

        return $this->connectionName;
    }

    /**
     * Sets the connection address
     *
     * @throws FerryException
     * @param string $addy
     * @return void
     */
    public function setAddress($addy)
    {
        if (is_string($addy) === false)
        {
            throw new FerryException('Connection address must be a string.');
        }

        $this->address = $addy;
    }

    /**
     * Get the connection address
     *
     * @throws FerryException
     * @return string
     */
    public function getAddress()
    {
        if (is_null($this->address) === true)
        {
            throw new FerryException('Connection address has not been set.');
        }

        return $this->address;
    }

    /**
     * Set the subdomain
     *
     * @throws FerryException
     * @param string $domain
     * @return void
     */
    public function setDomain($domain)
    {
        if (is_string($domain) === false)
        {
            throw new FerryException('Domain must be a string.');
        }

        $this->domain = $domain;
    }

    /**
     * Get the subdomain
     * 
     * @throws FerryException
     * @return string
     */
    public function getDomain()
    {
        if (is_null($this->domain) === true OR strlen($this->domain) < 1)
        {
            throw new FerryException('Domain has not been set.');
        }

        return $this->domain;
    }

    /**
     * Set some connection options (not required)
     *
     * @param array $options
     * @return void
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get connection options
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Build a full address to connect to
     *
     * @return void
     */
    public function buildFullAddress()
    {
        $this->fullAddress = sprintf($this->getAddress(), $this->getDomain(), $this->getName());
    }

    /**
     * Retrieve the full address
     *
     * @return string
     */
    public function getFullAddress()
    {
        return $this->fullAddress;
    }

    /**
     * Start SOAP connection
     *
     * @throws FerryException
     * @param string $connectName
     * @return SoapClient
     **/
    public function start($connectName = null)
    {
        // Optionally pass connection/api name when starting connection
        if (is_null($connectName) === false)
        {
            $this->setName($connectName);
        }

        // Build full address
        $this->buildFullAddress();

        try
        {
            // Start SOAP connection instance
            return new SoapClient($this->fullAddress, $this->options);  
        }
        catch (Exception $error)
        {
            // Note sure if Soap Fault or...?
            throw new FerryException($error->getMessage());
        }
    }
}