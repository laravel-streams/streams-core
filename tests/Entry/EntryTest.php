<?php


use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class EntryTest extends StreamsTestCase
{
    /**
     * @todo complete test by determining why the testing stream can't pick up the scaffolded file inside orchestra
     */
    public function testArrayable()
    {
        $this->markTestIncomplete();
        $this->setUpTestEntry();
        $entry = $this->getTestingStream()->repository()->find('test');

        $this->assertInstanceOf(Arrayable::class, $entry);
        $this->assertTrue(is_array($entry->toArray()));
    }

    /**
     * @todo complete test by determining why the testing stream can't pick up the scaffolded file inside orchestra
     */
    public function testJsonable()
    {
        $this->markTestIncomplete();
        $this->setUpTestEntry();
        $entry = $this->getTestingStream()->repository()->find('test');

        $this->assertInstanceOf(Jsonable::class, $entry);
        $this->assertTrue(is_string($entry->toJson()));
    }
}
