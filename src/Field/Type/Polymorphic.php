<?php

namespace Anomaly\Streams\Platform\Field\Type;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Field\FieldType;
use Anomaly\Streams\Platform\Support\Facades\Streams;

/**
 * Class Polymorphic
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Polymorphic extends FieldType
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
     * @return EntryInterface|null
     */
    public function expand($value)
    {
        $stream = $this->entry->{Arr::get($this->config, 'morph_type', $this->field . '_type')};
        $key = $this->entry->{Arr::get($this->config, 'foreign_key', $this->field . '_id')};
        
        return Streams::entries('pages_default')->find($key);
    }
}
