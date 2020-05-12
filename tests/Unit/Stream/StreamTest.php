<?php

use Anomaly\Streams\Platform\Stream\Stream;
use Tests\TestCase;

class StreamTest extends TestCase
{
    public function testCanReturnRepository()
    {
        die(realpath(__DIR__ . '/../../'));
        //dd(new Stream(json_decode(file_get_contents(__DIR__ . '/../../../streams/data/widgets.json'), true)));

        $this->markTestIncomplete();
    }
}
