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
 * @method static bool exists(string $handle)
 * @method static \Streams\Core\Stream\Stream build($stream)
 * @method static \Streams\Core\Stream\Stream load(string $file)
 * @method static \Streams\Core\Stream\Stream make(string $stream)
 * @method static \Streams\Core\Stream\Stream register(array $stream)
 * @method static \Streams\Core\Criteria\Criteria entries(string $stream)
 * @method static \Streams\Core\Repository\Repository repository(string $stream)
 * @method static \Illuminate\Support\Collection collection()
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
