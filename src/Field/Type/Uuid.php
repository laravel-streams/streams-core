<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Field\Factory\UuidGenerator;

class Uuid extends FieldType
{

    public function default()
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
