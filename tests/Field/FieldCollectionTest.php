<?php

namespace Streams\Core\Tests\Field;

use Tests\TestCase;
use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;

class FieldCollectionTest extends TestCase
{

    public function test_maps_keys_to_getter()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $this->assertInstanceOf(Field::class, Streams::make('testing.litmus')->fields->uuid);
    }
}
