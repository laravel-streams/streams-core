<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\UuidSchema;
use Streams\Core\Field\Presenter\StringPresenter;

class UuidFieldType extends Field
{

    public function default($value)
    {
        return $this->generate();
    }

    public function generate()
    {
        return (string) Str::uuid();
    }

    public function getPresenterName()
    {
        return StringPresenter::class;
    }

    public function getSchemaName()
    {
        return UuidSchema::class;
    }
}
