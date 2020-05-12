<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

class StreamTest extends TestCase
{
    public function testCanReturnRepository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, $this->stream()->repository());
    }

    /**
     * Return the testing stream.
     */
    protected function stream()
    {
        return new Stream(json_decode(file_get_contents(realpath(__DIR__ . '/../../streams/data/widgets.json')), true));
    }
}
