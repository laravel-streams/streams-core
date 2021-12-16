<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\HashValue;
use Illuminate\Support\Facades\Hash as HashFacade;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Hash extends FieldType
{
    public function modify($value)
    {
        if (strpos($value, '$2y$') === 0 && strlen($value) == 60) {
            return $value;
        }

        return HashFacade::make($value);
    }

    public function getValueName()
    {
        return HashValue::class;
    }

    public function schema()
    {
        return Schema::string($this->field->handle)
            ->format(Schema::FORMAT_PASSWORD);
    }

    public function generate()
    {
        return HashFacade::make($this->generator()->text(15, 50));
    }
}
