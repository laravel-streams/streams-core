<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\StringSchema;
use Streams\Core\Field\Decorator\StringDecorator;

class SlugFieldType extends Field
{
    public function rules(): array
    {
        return array_merge([
            'regex:/^[a-z0-9]+(?:[-_][a-z0-9]+)*$/',
        ], parent::rules());
    }

    public function cast($value)
    {
        return Str::slug($value, $this->config('separator') ?: '-');
    }
    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function generator()
    {
        return function () {
            return $this->modify(fake()->words(2, true));
        };
    }

    public function getSchemaName()
    {
        return StringSchema::class;
    }

    public function getDecoratorName()
    {
        return StringDecorator::class;
    }
}
