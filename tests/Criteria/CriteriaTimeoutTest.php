<?php

namespace Streams\Core\Tests\Criteria;

use Mockery;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Criteria\Contract\AdapterInterface;

class CriteriaTimeoutTest extends CoreTestCase
{
    private function criteria(): Criteria
    {
        return new class(Streams::make('films'), Mockery::mock(AdapterInterface::class)) extends Criteria
        {
            public float $clock = 0;

            public float $hydrationSeconds = 0;

            protected function monotonicTime(): float
            {
                return $this->clock;
            }

            protected function make($result): \Streams\Core\Entry\Contract\EntryInterface
            {
                $entry = parent::make($result);
                $this->clock += $this->hydrationSeconds;

                return $entry;
            }
        };
    }

    public function test_timeout_rejects_results_after_the_query_budget_expires()
    {
        $criteria = $this->criteria();
        $criteria->adapter->shouldReceive('get')->once()->with([])->andReturnUsing(function () use ($criteria) {
            $criteria->clock = 31;

            return [];
        });

        $this->expectException(\Streams\Core\Criteria\Exception\QueryTimedOut::class);
        $criteria->timeout(30)->get();
    }

    public function test_timeout_does_not_cache_expired_query_results()
    {
        $criteria = $this->criteria();
        $cache = Streams::make('films')->cache();
        $criteria->adapter->shouldReceive('get')->once()->with([])->andReturnUsing(function () use ($criteria) {
            $criteria->clock = 31;

            return [];
        });

        try {
            $criteria->timeout(30)->cache(60, 'expired-query')->get();
            $this->fail('An expired query must throw.');
        } catch (\Streams\Core\Criteria\Exception\QueryTimedOut $exception) {
            $this->assertFalse($cache->has('expired-query'));
        }

        $criteria->adapter->shouldReceive('get')->once()->with([])->andReturn([]);
        $this->assertCount(0, $criteria->cache(60, 'expired-query')->get());
        $this->assertTrue($cache->has('expired-query'));
    }

    public function test_timeout_does_not_cache_expired_counts()
    {
        $criteria = $this->criteria();
        $cache = Streams::make('films')->cache();
        $criteria->adapter->shouldReceive('count')->once()->with([])->andReturnUsing(function () use ($criteria) {
            $criteria->clock = 31;

            return 7;
        });

        try {
            $criteria->timeout(30)->cache(60, 'expired-count')->count();
            $this->fail('An expired count must throw.');
        } catch (\Streams\Core\Criteria\Exception\QueryTimedOut $exception) {
            $this->assertFalse($cache->has('expired-count'));
        }

        $criteria->adapter->shouldReceive('count')->once()->with([])->andReturn(7);
        $this->assertSame(7, $criteria->cache(60, 'expired-count')->count());
        $this->assertTrue($cache->has('expired-count'));
    }

    public function test_timeout_includes_hydration_and_starts_when_the_query_runs()
    {
        $criteria = $this->criteria()->timeout(30);
        $criteria->clock = 500;
        $criteria->hydrationSeconds = 30;
        $criteria->adapter->shouldReceive('get')->once()->with([])->andReturn([
            ['episode_id' => 100, 'title' => 'Hydration fixture'],
        ]);

        try {
            $criteria->get();
            $this->fail('Hydration exhausted the query budget.');
        } catch (\Streams\Core\Criteria\Exception\QueryTimedOut $exception) {
            $this->assertSame(530.0, $criteria->clock);
        }

        $criteria->hydrationSeconds = 0;
        $criteria->adapter->shouldReceive('get')->once()->with([])->andReturn([]);
        $this->assertCount(0, $criteria->get());
    }

    public function test_timeout_applies_to_counts_and_resets_the_deadline_after_failure()
    {
        $criteria = $this->criteria();
        $criteria->adapter->shouldReceive('count')->once()->with([])->andReturnUsing(function () use ($criteria) {
            $criteria->clock = 31;

            return 7;
        });

        try {
            $criteria->timeout(30)->count();
            $this->fail('An expired count must throw.');
        } catch (\Streams\Core\Criteria\Exception\QueryTimedOut $exception) {
            $this->assertStringContainsString('30', $exception->getMessage());
        }

        $criteria->adapter->shouldReceive('get')->once()->with([])->andReturn([]);
        $this->assertCount(0, $criteria->get());
    }

    public function test_timeout_allows_queries_within_budget_without_forwarding_to_adapter()
    {
        $criteria = $this->criteria();
        $criteria->adapter->shouldReceive('get')->once()->with([])->andReturn([]);

        $this->assertSame($criteria, $criteria->timeout(30));
        $this->assertCount(0, $criteria->get());
    }

    public function test_timeout_requires_a_positive_finite_duration()
    {
        foreach ([0, -1, INF, NAN] as $seconds) {
            try {
                $this->criteria()->timeout($seconds);
                $this->fail('Invalid timeout must throw.');
            } catch (\InvalidArgumentException $exception) {
                $this->assertNotEmpty($exception->getMessage());
            }
        }
    }
}
