<?php


use Streams\Core\Support\Resolver;

class ResolverTest extends StreamsTestCase
{
    public function testCanResolveHandler()
    {
        /** @var Resolver $resolver */
        $resolver = app(Resolver::class);

        $this->assertEquals('foo', $resolver->resolve(ResolverStub::class, [], ['method' => 'run']));
    }

    public function testCanResolveCustomHandler()
    {
        /** @var Resolver $resolver */
        $resolver = app(Resolver::class);

        $this->assertEquals('foo_test', $resolver->resolve(ResolverStub::class . '@handle', ['prefix' => 'foo_']));
    }

    public function testFailsQuietly()
    {
        /** @var Resolver $resolver */
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
