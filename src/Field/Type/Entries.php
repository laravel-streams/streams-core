<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

/**
 * Class Entries
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Entries extends FieldType
{
    /**
     * The class attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        $stream = Streams::entries($this->config['stream']);

        return new Collection(array_map(function ($value) use ($stream) {
            return $stream->newInstance($value);
        }, (array)$value));
    }
}
