<?php

namespace Streams\Core\Application;

use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 * Applications are a way to map multiple 
 * application configurations to URL patterns.
 */
class Application
{

    use HasMemory;
    use Prototype;
    use Macroable;
    use FiresCallbacks;

    public function toArray(): array
    {
        return Hydrator::dehydrate($this, [
            '__listeners',
            '__observers'
        ]);
    }

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
