<?php namespace Labtech\Ferry;

/**
 * Connection Interface
 *
 * @package Ferry
 **/
interface ConnectionInterface
{
    public function setOptions(array $options);
    public function getOptions();
    public function start();
}