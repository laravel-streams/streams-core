<?php

namespace Streams\Core\Tests\Entry;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class EntryFactoryTest extends TestCase
{

    public function testCanCreate()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));

        $fake = Streams::make('testing.fakers')->factory()->create();

        $this->assertIsNumeric($fake->id);
    }

    public function testCanCreateWithData()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));

        $fake = Streams::make('testing.fakers')->factory()->create([
            'string' => 'Test String',
        ]);

        $this->assertEquals('Test String', $fake->string);
    }

    public function testCanCollect()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));

        $fakes = Streams::make('testing.fakers')->factory()->collect(3);

        $this->assertEquals(3, $fakes->count());
        $this->assertIsNumeric(3, $fakes->first()->id);
    }
}
