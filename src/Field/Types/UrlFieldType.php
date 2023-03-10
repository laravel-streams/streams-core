<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\UrlSchema;
use Streams\Core\Field\Decorator\UrlDecorator;

class UrlFieldType extends Field
{
    public $rules = [
        'url',
    ];

    public function getSchemaName()
    {
        return UrlSchema::class;
    }

    public function getDecoratorName()
    {
        return UrlDecorator::class;
    }

    public function generator()
    {
        return function () {
            return fake()->url();
        };
    }
}
