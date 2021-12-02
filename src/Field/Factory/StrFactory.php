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
        $min = Arr::get($parameters, 'min', $this->type->field->ruleParameter('min') ?: 0);
        $max = Arr::get($parameters, 'max', $this->type->field->ruleParameter('max') ?: 200);

        if (!$min && !$max) {
            return $this->faker()->text();
        }

        return $this->faker()->realTextBetween($min, $max);
    }

    public function faker(): Generator
    {
        return $this->once(__METHOD__, fn () => app('faker'));
    }
}
