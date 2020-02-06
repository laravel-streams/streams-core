<?php

namespace Anomaly\Streams\Platform\Model\Traits;

use Anomaly\Streams\Platform\Stream\StreamBuilder;
use Anomaly\Streams\Platform\Stream\StreamManager;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Support\Traits\Macroable;

/**
 * Class Streams
 *
 * @property array $stream
 * 
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Streams
{

    //use Hookable; // @todo remove commenting when models removed (full trait)

    /**
     * Das boot.
     */
    public static function bootStreams()
    {
        self::$stream['model'] = self::class;

        StreamManager::put(self::class, self::$stream = StreamBuilder::build(self::$stream));
    }

    /**
     * Return the stream.
     *
     * @return StreamInterface
     */
    public function stream()
    {
        return self::$stream;
    }

    /**
     * Pass attributes through streams.
     *
     * @param string $key
     */
    public function __get($key)
    {
        // Check if it's a relationship first.
        // @todo remove this hardcoded relationship check.
        if (in_array($key, ['created_by', 'updated_by', 'roles'])) {
            return parent::getRelationValue($key);
        }

        if (!$this->hasGetMutator($key) && $this->stream()->fields->has($key)) {
            return $this->getFieldValue($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->hasHook($hook = snake_case($method))) {
            return $this->call($hook, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
