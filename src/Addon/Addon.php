<?php

namespace Streams\Core\Addon;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 * Addons are composer packages of type "streams-addon".
 */
class Addon implements Arrayable, Jsonable
{
    use Prototype;
    use HasMemory;
    use Macroable;
    use FiresCallbacks;

    public function provides(string $service): bool
    {
        foreach (Arr::get($this->composer, 'extra.streams.provides', []) as $provision) {
            if (Str::is($service, $provision)) {
                return true;
            }
        }

        return false;
    }

    public function toArray(): array
    {
        return Hydrator::dehydrate($this, [
            '__observers',
            '__listeners',
        ]);
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
