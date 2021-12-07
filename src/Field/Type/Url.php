<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\UrlValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Url extends FieldType
{

    protected $__attributes = [
        'rules' => [
            'url',
        ],
    ];

    public function expand($value)
    {
        return new UrlValue($value);
    }

    public function schema()
    {
        return Schema::string($this->field->handle)
            ->pattern('https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)');
    }

    public function generate()
    {
        return $this->generator()->url();
    }
}
