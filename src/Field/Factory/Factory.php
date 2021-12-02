<?php

namespace Streams\Core\Field\Factory;

use Faker\Generator;
use Illuminate\Support\Arr;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Support\Traits\ForwardsCalls;

class Factory
{
    use Macroable;
    use HasMemory;
    use ForwardsCalls;

    protected FieldType $type;

    public function __construct(FieldType $type)
    {
        $this->type = $type;
    }

    public function create($parameters = [])
    {
        return $this->faker()->text();
    }

    public function faker(): Generator
    {
        return $this->once(__METHOD__, fn () => app('faker'));
    }
}
