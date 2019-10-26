<?php

namespace Qklin\Notify\Facades;

use Illuminate\Support\Facades\Facade;

class Notify extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'qklin.notify';
    }
}