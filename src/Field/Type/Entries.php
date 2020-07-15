<?php

namespace Anomaly\Streams\Platform\Field\Type;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Field\FieldType;
use Anomaly\Streams\Platform\Support\Facades\Streams;

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
