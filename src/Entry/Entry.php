<?php

namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Jsonable;
use Anomaly\Streams\Platform\Stream\Stream;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class Entry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 *
 */
class Entry implements EntryInterface, Arrayable, Jsonable
{

    use Properties;

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
     * @param StreamInterface $stream
     * @param array $attributes
     */
    public function __construct(Stream $stream, array $attributes = [])
    {
        $this->stream = $stream;

        $this->properties = Arr::make($stream->fields->toArray());

        $this->fill($attributes);
    }

    /**
     * Return the entry stream.
     */
    public function stream()
    {
        return $this->stream;
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
