<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\UrlValue;

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

    public function generate()
    {
        return $this->generator()->url();
    }
}
