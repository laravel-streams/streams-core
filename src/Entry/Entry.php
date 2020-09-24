<?php

namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Traits\Fluency;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
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

    use Fluency {
        Fluency::__construct as private constructFluency;
    }

    /**
     * The stream instance.
     *
     * @var Stream
     */
    public $stream;

    /**
     * Create a new
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->stream = Arr::pull($attributes, 'stream');

        $this->constructFluency($attributes);

        /**
         * Extend another entry.
         */
        if ($this->hasPrototypeAttribute('streams__extends')) {

            $parent = $this->stream->repository()->find($this->streams__extends);

            $this->setPrototypeAttributes(
                array_merge($parent->toArray(), $this->toArray(), ['parent' => $parent])
            );
        }

        // /**
        //  * Load another entry.
        //  */
        // if ($this->hasPrototypeAttribute('streams__load')) {

        //     $parent = $this->stream->repository()->find($this->streams__load);

        //     $parent->loadPrototypeAttributes(
        //         array_merge($this->toArray(), ['parent' => $parent])
        //     );

        //     $this->setPrototypeAttributes($parent->getPrototypeAttributes());
        // }
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
     * Return a string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
