<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Facades\Hash;

/**
 * Class HashValue
 * 
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class HashValue extends Value
{

    /**
     * Compare a value to
     * the hashed value.
     *
     * @param $value
     */
    public function check($value)
    {
        return Hash::check($value, $this->value);
    }
}
