<?php namespace Labtech\Ferry\Facades;

use Illuminate\Support\Facades\Facade;

class SoapConnectionFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'ferrySoapConnection'; }
}