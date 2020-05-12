<?php

use Tests\TestCase;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Stream\Stream;

class EntryTest extends TestCase
{
    public function testArrayable()
    {
        $entry = $this->stream()->repository()->find('foo_widget');

        $this->assertInstanceOf(Arrayable::class, $entry);
        $this->assertTrue(is_array($entry->toArray()));
    }

    public function testJsonable()
    {
        $entry = $this->stream()->repository()->find('foo_widget');

        $this->assertInstanceOf(Jsonable::class, $entry);
        $this->assertTrue(is_string($entry->toJson()));
    }

    /**
     * Return the testing stream.
     */
    protected function stream()
    {
        return new Stream(json_decode(file_get_contents(realpath(__DIR__ . '/../../streams/data/widgets.json')), true));
    }
}
