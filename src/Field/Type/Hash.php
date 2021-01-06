<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\HashValue;
use Illuminate\Support\Facades\Hash as FacadesHash;

class Hash extends Str
{
    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return FacadesHash::make($value);
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return new HashValue($value);
    }
}
