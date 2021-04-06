<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;

/**
 * Class Slug
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Slug extends FieldType
{
    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return Str::slug($value, \Illuminate\Support\Arr::get($this->config, 'separator', '-'));
    }

    // /**
    //  * Expand the value.
    //  *
    //  * @param $value
    //  * @return Collection
    //  */
    // public function expand($value)
    // {
    //     return new DatetimeValue($value);
    // }
}
