<?php


use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

class StreamTest extends StreamsTestCase
{
    public function testCanReturnRepository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, $this->getTestingStream()->repository());
    }
}
