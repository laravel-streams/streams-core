<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Support\Resolver;

class ResolverTest extends TestCase
{
    public function testCanResolveHandler()
    {
        $resolver = app(Resolver::class);

        $this->assertEquals('foo', $resolver->resolve(ResolverStub::class, [], ['method' => 'run']));
    }

    public function testCanResolveCustomHandler()
    {
        $resolver = app(Resolver::class);

        $this->assertEquals('foo_test', $resolver->resolve(ResolverStub::class . '@handle', ['prefix' => 'foo_']));
    }

    public function testFailsQuietly()
    {
        $resolver = app(Resolver::class);

        $this->assertEquals(null, $resolver->resolve('Bad@handle'));
    }
}

class ResolverStub
{
    public function handle($prefix)
    {
        return $prefix . 'test';
    }

    public function run()
    {
        return 'foo';
    }
}
