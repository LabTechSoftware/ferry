<?php namespace Labtech\Ferry\Facades;

use Illuminate\Support\Facades\Facade;

class CurlConnectionFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'ferryCurlConnection'; }
}