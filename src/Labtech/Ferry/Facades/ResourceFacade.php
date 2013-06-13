<?php namespace Labtech\Ferry\Facades;

use Illuminate\Support\Facades\Facade;

class ResourceFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'ferryResource'; }
}