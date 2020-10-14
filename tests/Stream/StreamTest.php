<?php


use Streams\Core\Stream\Stream;
use Streams\Core\Repository\Contract\RepositoryInterface;

class StreamTest extends StreamsTestCase
{
    public function testCanReturnRepository()
    {
        $this->assertInstanceOf(RepositoryInterface::class, $this->getTestingStream()->repository());
    }
}
