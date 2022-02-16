<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Overrides extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'overrides';
    }
}
