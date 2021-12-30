<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\UrlValue;
use Streams\Core\Field\Schema\UrlSchema;

class Url extends FieldType
{

    protected $__attributes = [
        'rules' => [
            'url',
        ],
    ];

    public function getValueName()
    {
        return UrlValue::class;
    }

    public function getSchemaName()
    {
        return UrlSchema::class;
    }

    public function generate()
    {
        return $this->generator()->url();
    }
}
