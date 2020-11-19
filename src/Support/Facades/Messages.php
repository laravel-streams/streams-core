<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Messages
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @property Illuminate\Session\Store $session
 * @method static \Streams\Core\Message\MessageManager add($type, $message)
 * @method static \Streams\Core\Message\MessageManager merge(string $key, array $message)
 * @method static \Streams\Core\Message\MessageManager get()
 * @method static \Streams\Core\Message\MessageManager pull()
 * @method static \Streams\Core\Message\MessageManager error($message)
 * @method static \Streams\Core\Message\MessageManager info($message)
 * @method static \Streams\Core\Message\MessageManager success($message)
 * @method static \Streams\Core\Message\MessageManager warning($message)
 * @method static \Streams\Core\Message\MessageManager danger($message)
 * @method static \Streams\Core\Message\MessageManager important($message)
 * @method static \Streams\Core\Message\MessageManager flush()
 */
class Messages extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'messages';
    }
}
