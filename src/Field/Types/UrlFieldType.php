<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\UrlValue;
use Streams\Core\Field\Schema\UrlSchema;

class UrlFieldType extends Field
{

    protected $__attributes = [
        'rules' => [
            'url',
        ],
    ];

    public function getPresenterName()
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
