<?php 

class CurlerException extends Exception {}

/**
 * Curler is a simple cURL service
 *
 * @package Laravel
 * @category Library
 * @author Andre Zavala
 **/
class Curler
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
     * Start'er up (initialize curl)
     *
     * @return void
     **/
    public function __construct()
    {
        $this->_curlConn = curl_init();

        // Always force return transfer as a string value instead of outputting directly
        $this->setOptions(array(CURLOPT_RETURNTRANSFER => true));
    }

    /**
     * Start'er up - pass through any options for the new cURL connection
     *
     * @throws CurlerException
     * @param array $curlOptions
     * @return Curler
     **/
    public function setOptions(array $curlOptions)
    {
        // Options?
        if (count($curlOptions) > 0)
        {
            // Loop through the provided options
            foreach ($curlOptions as $optKey => $optVal)
            {
                // Set curl option
                curl_setopt($this->_curlConn, $optKey, $optVal);
            }

            return $this;
        }
        else
        {
            throw new CurlerException('Options not provided for Curler library.');
        }
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
    public function execute()
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