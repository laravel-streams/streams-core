<?php

namespace Streams\Core\Tests\Field;

use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Tests\CoreTestCase;

class FieldSchemaTest extends CoreTestCase
{
    public function test_it_returns_type_json()
    {
        $schema = Streams::make('films')->fields->get('title')->schema();

        $this->assertSame('{"type":"string"}', $schema->type()->toJson());
    }

    public function test_it_returns_property_json()
    {
        $schema = Streams::make('films')->fields->get('title')->schema();

        $this->assertSame(
            '{"title":"Title","type":"string","maxLength":25}',
            $schema->property()->toJson()
        );
    }
}
