<?php

namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class Entry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 *
 */
class Entry
{

    use HasAttributes;

    /**
     * The stream instance.
     *
     * @var Stream
     */
    protected $stream;

    /**
     * The entry attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new Entry instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [], Stream $stream)
    {
        $this->stream = $stream;
        $this->attributes = $attributes;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param  string  $key
     * @param  mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
