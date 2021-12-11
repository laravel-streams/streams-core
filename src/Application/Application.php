<?php

namespace Streams\Core\Application;

use Streams\Core\Entry\Entry;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 * Applications are a way to map multiple 
 * application configurations to URL patterns.
 */
class Application extends Entry
{
}
