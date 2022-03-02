<?php

namespace Streams\Core\Tests\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\UuidFieldType;
use Streams\Core\Field\Presenter\StringPresenter;

class UuidFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_default_value()
    {
        $field = new UuidFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertIsString($field->default(true));
    }

    public function test_it_returns_string_value()
    {
        $field = new UuidFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(
            StringPresenter::class,
            $field->decorate((string) Str::uuid())
        );
    }
}
