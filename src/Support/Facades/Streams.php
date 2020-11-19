<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Streams
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @method static \Streams\Core\Stream\StreamManager make(string $stream)
 * @method static \Streams\Core\Stream\StreamManager has(string $handle)
 * @method static \Streams\Core\Stream\StreamManager build($stream)
 * @method static \Streams\Core\Stream\StreamManager load(string $file)
 * @method static \Streams\Core\Stream\StreamManager register(array $stream)
 * @method static \Streams\Core\Stream\StreamManager entries(string $stream)
 * @method static \Streams\Core\Stream\StreamManager repository(string $stream)
 * @method static \Streams\Core\Stream\StreamManager collection()
 */
class Streams extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'streams';
    }
}
