<?php

namespace TestingAspire\Application\Facades;

use Illuminate\Support\Facades\Facade;

class Json extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'json';
    }
}
