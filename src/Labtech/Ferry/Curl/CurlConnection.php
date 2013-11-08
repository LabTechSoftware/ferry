<?php namespace Labtech\Ferry\Curl;

use Labtech\Ferry\ConnectionInterface,
    Labtech\Ferry\FerryException;

/**
 * CURL Connection
 *
 * @package Ferry
 * @category CURL
 */
class CurlConnection implements ConnectionInterface
{
    /**
     * cURL Connection Storage
     */
    protected $_curlConn = null;

    /**
     * HTTP Response Status
     *
     * @var string
     **/
    protected $responseStatus;

    /**
     * HTTP Response Content Type
     *
     * @var string
     **/
    protected $responseContentType;

    /**
     * cURL Options
     *
     * @var array
     */
    protected $curlOptions = array();

    /**
     * Start'er up -- optionally turn off return transfer option
     *
     * @param boolean $returnTransfter
     * @return void
     **/
    public function __construct($returnTransfer = true)
    {
        $this->_curlConn = curl_init();

        // Always force return transfer as a string value instead of outputting directly
        $this->setOptions(array(CURLOPT_RETURNTRANSFER => $returnTransfer));
    }

    /**
     * Start'er up - pass through any options for the new cURL connection
     *
     * @throws FerryException
     * @param array $options
     * @return CurlConnection
     **/
    public function setOptions(array $options)
    {
        // Options?
        if (count($options) > 0)
        {
            // Loop through the provided options
            foreach ($options as $optKey => $optVal)
            {
                // Set in options array 
                $this->curlOptions[$optKey] = $optVal;

                // Set curl option
                curl_setopt($this->_curlConn, $optKey, $optVal);
            }

            return $this;
        }
        else
        {
            throw new FerryException('Options not provided for Curl library.');
        }
    }

    /**
     * Get the current connection options
     *
     * @return array
     **/
    public function getOptions()
    {
        return $this->curlOptions;
    }

    /**
     * Set the HTTP response status
     *
     * @return void 
     **/
    public function setResponseStatus()
    {
        $this->responseStatus = curl_getinfo($this->_curlConn, CURLINFO_HTTP_CODE);
    }

    /**
     * Get the HTTP response status
     *
     * @return string 
     **/
    public function getResponseStatus()
    {
        return $this->responseStatus;
    }

    /**
     * Look up errors from the previous request
     *
     * @return string
     **/
    public function errors()
    {
        return curl_error($this->_curlConn);
    }

    /**
     * Set the HTTP Content Type
     *
     * @return void 
     **/
    public function setResponseContentType()
    {
        $this->responseContentType = curl_getinfo($this->_curlConn, CURLINFO_CONTENT_TYPE);
    }

    /**
     * Get the HTTP Content Type
     *
     * @return string 
     **/
    public function getResponseContentType()
    {
        return $this->responseContentType;
    }

    /**
     * Execute the cURL command / Return the result
     *
     * @return mixed
     **/
    public function start()
    {
        // Execute
        $execute = curl_exec($this->_curlConn);
        
        // Set response status
        $this->setResponseStatus();

        // Set content type
        $this->setResponseContentType();
    
        // Return execute results
        return $execute;
    }

    /**
     * Close the cURL connection
     *
     * @return void
     */
    public function __destruct()
    {
        curl_close($this->_curlConn);
    }
}