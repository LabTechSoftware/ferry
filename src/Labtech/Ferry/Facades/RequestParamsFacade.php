<?php namespace Labtech\Ferry\Facades;

use Illuminate\Support\Facades\Facade;

class RequestParamsFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'ferryRequestParams'; }
}