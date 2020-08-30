<?php

namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;
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
    public $stream;

    public function __construct(array $attributes = [])
    {
        $this->stream = Arr::pull($attributes, 'stream');

        $this->fill(array_merge($this->attributes, $attributes));

        $this->original = $this->attributes;
    }

    /**
     * Return the entry stream.
     */
    public function stream()
    {
        return $this->stream;
    }

    /**
     * Save the entry.
     *
     * @return bool
     */
    public function save()
    {
        return $this->stream
            ->repository()
            ->save($this);
    }

    /**
     * Delete the entry.
     *
     * @return bool
     */
    public function delete()
    {
        return $this->stream
            ->repository()
            ->delete($this);
    }

    /**
     * Return the entry validator.
     * 
     * @return Validator
     */
    public function validator()
    {
        return $this->stream->validator($this);
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

    /**
     * Return a string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
