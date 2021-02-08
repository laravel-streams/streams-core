<?php

namespace Streams\Core\Entry;

use ArrayAccess;
use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Illuminate\Validation\Validator;
use Streams\Core\Support\Traits\Fluency;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Entry\Contract\EntryInterface;

class Entry implements
    EntryInterface,
    ArrayAccess,
    Arrayable,
    Jsonable
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
    }

    /**
     * Return the entry stream.
     * 
     * @return Stream
     */
    public function stream()
    {
        if ($this->stream instanceof Stream) {
            return $this->stream;
        }

        return $this->stream = Streams::make($this->stream);
    }

    /**
     * Save the entry.
     * 
     * @param array $options
     * @var bool
     */
    public function save(array $options = [])
    {
        return $this->stream()
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
        return $this->stream()
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
        return $this->stream()->validator($this);
    }

    // /**
    //  * Load an entry over this one.
    //  *
    //  * @param $identifier
    //  * @return $this
    //  */
    // protected function loadEntry($identifier)
    // {
    //     $loaded = $this->stream()->repository()->find($identifier);

    //     $this->setPrototypeAttributes(
    //         array_merge($this->toArray(), $loaded->toArray())
    //     );

    //     return $this;
    // }

    // /**
    //  * Extend over another entry.
    //  *
    //  * @param $identifier
    //  * @return $this
    //  */
    // protected function extendEntry($identifier)
    // {
    //     $extended = $this->stream()->repository()->find($identifier);

    //     $this->setPrototypeAttributes(
    //         array_merge($extended->toArray(), $this->toArray())
    //     );

    //     return $this;
    // }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_diff_key(Hydrator::dehydrate($this), array_flip([
            'stream',
        ]));
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
