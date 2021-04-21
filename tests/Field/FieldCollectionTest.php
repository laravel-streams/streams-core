<?php

namespace Streams\Core\Tests\Field;

use Tests\TestCase;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Core\Field\Type\Integer;
use Streams\Core\Field\FieldCollection;
use Streams\Core\Support\Facades\Streams;

class FieldCollectionTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testFieldInstance()
    {
        $this->assertInstanceOf(FieldCollection::class, Streams::make('testing.examples')->fields);
    }
}
