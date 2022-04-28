<?php

namespace Sashalenz\Wireforms\Facades;

use Illuminate\Support\Facades\Facade;

class Wireforms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'wireforms';
    }
}
