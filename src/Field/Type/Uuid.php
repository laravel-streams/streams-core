<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;

class Uuid extends FieldType
{

    public function default($value)
    {
        return $this->generate();
    }

    public function expand($value)
    {
        return new StrValue($value);
    }

    public function generate()
    {
        return $this->generator()->uuid();
    }
}
