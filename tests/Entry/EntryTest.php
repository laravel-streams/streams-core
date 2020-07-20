<?php


use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class EntryTest extends StreamsTestCase
{
    public function testArrayable()
    {
        $this->setUpTestEntry();
        $entry = $this->getTestingStream()->repository()->find('test');

        $this->assertInstanceOf(Arrayable::class, $entry);
        $this->assertTrue(is_array($entry->toArray()));
    }

    public function testJsonable()
    {
        $this->setUpTestEntry();
        $entry = $this->getTestingStream()->repository()->find('test');

        $this->assertInstanceOf(Jsonable::class, $entry);
        $this->assertTrue(is_string($entry->toJson()));
    }
}
