<?php

namespace Streams\Core\Field\Factory;

use Faker\Factory;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Traits\HasMemory;

class Generator
{
    use Macroable;
    use HasMemory;

    protected FieldType $field;

    public function __construct(FieldType $field)
    {
        $this->field = $field;
    }

    public function create()
    {
        return $this->generator()->text();
    }

    public function generator()
    {
        return $this->once(__METHOD__, fn () => Factory::create());
    }
}
