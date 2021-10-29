<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Factory\ArrGenerator;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;

class Arr extends FieldType
{
    protected $__attributes = [
        'rules' => [
            'array',
        ],
    ];

    public function modify($value)
    {
        if (is_string($value) && $json = json_decode($value)) {
            $value = $json;
        }

        if (is_string($value) && is_null($json)) {
            $value = explode("\n", $value);
        }

        return (array) $value;
    }

    public function expand($value)
    {
        return new ArrValue($value);
    }

    public function generator(): ArrGenerator
    {
        return new ArrGenerator($this);
    }
}
