<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\Factory\SlugGenerator;
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
        return Str::slug($value, $this->field->config('seperator') ?: '_');
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

    public function generator(): SlugGenerator
    {
        return new SlugGenerator($this);
    }
}
