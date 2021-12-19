<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Arr;
use Streams\Core\Field\Type\Select;

class SelectValue extends Value
{

    protected Select $type;

    public function value()
    {
        return Arr::get($this->type->options(), $this->value);
    }

    /**
     * Normalize the URL by default.
     *
     * @return bool|string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
