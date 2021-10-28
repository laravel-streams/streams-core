<?php

namespace Streams\Core\Tests\Stream\Criteria\Adapter;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class AbstractAdapterTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testOrWhereConstraint()
    {
        $this->assertEquals(2, Streams::entries('testing.examples')->setParameters([
            'where' => [
                ['id', 'first'],
            ],
            'or_where' => [
                ['id', 'second'],
            ]
        ])->count());
    }
}
