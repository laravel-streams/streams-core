<?php

namespace Anomaly\Streams\Platform\Field\Type;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Field\FieldType;

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
        return Str::slug($value);
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
