<?php

namespace Streams\Core\Tests\Validation;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Validation\StreamsPresenceVerifier;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\ConnectionInterface;

class StreamsPresenceVerifierTest extends CoreTestCase
{
    /**
     * @test
     */
    public function it_returns_stream_criteria_when_stream_exists()
    {
        $this->markTestSkipped('Needs to be reworked for new validation system.');
        $resolver = $this->createMock(ConnectionResolverInterface::class);
        $verifier = new StreamsPresenceVerifier($resolver);

        // Use existing films stream from test data
        $count = $verifier->getCount('films', 'title', 'The Empire Strikes Back');

        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function it_falls_back_to_parent_when_stream_does_not_exist()
    {
        $this->markTestSkipped('Needs to be reworked for new validation system.');
        $queryBuilder = $this->createMock(\Illuminate\Database\Query\Builder::class);
        
        $queryBuilder->expects($this->once())
            ->method('where')
            ->willReturnSelf();
            
        $queryBuilder->expects($this->once())
            ->method('count')
            ->willReturn(0);

        $connection = $this->createMock(ConnectionInterface::class);
        $connection->expects($this->once())
            ->method('table')
            ->with('users')
            ->willReturn($queryBuilder);

        $resolver = $this->createMock(ConnectionResolverInterface::class);
        $resolver->expects($this->once())
            ->method('connection')
            ->willReturn($connection);

        $verifier = new StreamsPresenceVerifier($resolver);

        $result = $verifier->getCount('users', 'email', 'test@example.com');

        $this->assertEquals(0, $result);
    }
}
