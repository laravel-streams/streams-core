<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\UrlSchema;
use Streams\Core\Field\Decorator\UrlDecorator;

class UrlFieldType extends Field
{

    protected $__attributes = [
        'rules' => [
            'url',
        ],
    ];

    public function getDecoratorName()
    {
        return UrlDecorator::class;
    }

    // public function getSchemaName()
    // {
    //     return UrlSchema::class;
    // }

    // public function generate()
    // {
    //     return $this->generator()->url();
    // }
}
