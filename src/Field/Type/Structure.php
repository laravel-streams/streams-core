<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Field\Schema\StructureSchema;

class Structure extends FieldType
{
    public function modify($value)
    {
        dd($value);
    }

    public function restore($value)
    {
        dd($value);
    }

    public function expand($value)
    {
        dd($value);
    }

    public function getSchemaName()
    {
        return StructureSchema::class;
    }

    public function generate()
    {
        for ($i = 0; $i < 10; $i++) {
            $values[$this->generator()->word()] = $this->generator()->randomElement([
                $this->generator()->word(),
                $this->generator()->randomNumber(),
            ]);
        }

        return $values;
    }
}
