<?php

namespace Anomaly\Streams\Platform\Field\Type;

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
        dd($value);
        return Streams::entries($this->config['stream'])->find($value);
    }
}
