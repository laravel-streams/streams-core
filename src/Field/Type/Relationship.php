<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

class Relationship extends FieldType
{
    public function expand($value)
    {
        return Streams::entries($this->field->config('related'))->find($value);
    }

    public function generate()
    {
        $possible = Streams::entries($this->field->config('related'))->limit(100)->get();

        return $possible->random()->id;
    }
}
