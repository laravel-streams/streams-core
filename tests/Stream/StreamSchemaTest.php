<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;

class StreamSchemaTest extends CoreTestCase
{
    public function test_it_returns_type_json()
    {
        $schema = Streams::schema('films');

        $this->assertJson($schema->tag()->toJson());
    }

    public function test_it_returns_object_json()
    {
        $schema = Streams::schema('films');

        $this->assertJson($schema->object()->toJson());
    }
}
