<?php

namespace Qklin\Notify;

use Illuminate\Support\Facades\Facade;

class Notify extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'qklin.notify';
    }
}