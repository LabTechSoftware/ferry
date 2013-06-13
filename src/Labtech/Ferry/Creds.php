<?php namespace Labtech\Ferry;

use Labtech\Ferry\FerryException;

/**
 * Credentials Container
 *
 * @package Ferry
 */
class Creds
{
    protected $credsArray = array();
    private $_userName = null;
    private $_userPass = null;

    /**
     * Set the username
     *
     * @throws FerryException
     * @param string $username
     * @return Creds
     **/
    public function setUsername($username = null)
    {
        if (is_string($username) !== true)
        {
            throw new FerryException('Username must be a string.');
        }

        $this->_userName = $username;
        return $this;
    }

    /**
     * Set the password
     *
     * @throws FerryException
     * @param string $password
     * @return Creds
     **/
    public function setPass($password = null)
    {
        if (is_string($password) !== true)
        {
            throw new FerryException('Password not properly formatted.');
        }

        $this->_userPass = $password;
        return $this;
    }

    /**
     * Utility method for checking/validating all credentials (class properties)
     *
     * @throws FerryException
     * @return void
     **/
    private function checkCreds()
    {
        // Username must be set
        if (is_null($this->_userName) === true)
        {
            throw new FerryException('Username has not been set.');
        }

        // Password must be set
        if (is_null($this->_userPass) === true)
        {
            throw new FerryException('Password has not been set.');
        }
    }

    /**
     * Return credentials in an array
     *
     * @return array
     **/
    public function getCredsArray()
    {
        // Check creds -- exception thrown if there is a problem
        $this->checkCreds();

        // Build a friendly credentials array
        $this->credsArray['username'] = $this->_userName;
        $this->credsArray['password'] = $this->_userPass;

        return $this->credsArray;
    }
}