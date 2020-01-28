<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Support\Presenter;
use Anomaly\Streams\Platform\Traits\Hookable;

class PresenterTest extends TestCase
{
    public function testCanAccessDecoratedObject()
    {
        $presenter = new PresenterStub(new ObjectStub());

        $this->assertInstanceOf(ObjectStub::class, $presenter->getObject());
    }

    public function testCanMapGetToPublicPresenterGetterMethods()
    {
        $presenter = new PresenterStub(new ObjectStub());

        $this->assertEquals(true, $presenter->secret);
        $this->assertEquals('baz', $presenter->foo_bar);
    }

    public function testCanMapGetToPublicPresenterMethods()
    {
        $presenter = new PresenterStub(new ObjectStub());

        $this->assertEquals('presenter.method', $presenter->presenter_method);
    }

    public function testCanMapGetToPublicGetterMethods()
    {
        $presenter = new Presenter(new ObjectStub());

        $this->assertEquals(true, $presenter->protected);
        $this->assertEquals('protected', $presenter->protected_value);
    }

    public function testCanMapGetToPublicMethods()
    {
        $presenter = new Presenter(new ObjectStub());

        $this->assertEquals('public', $presenter->public_method);
    }

    public function testCanPassthroughPublicMethods()
    {
        $presenter = new Presenter(new ObjectStub());

        $this->assertEquals('public', $presenter->publicMethod());
    }

    public function testCanAccessGetterStyleHooks()
    {
        $presenter = new Presenter(new ObjectStub());

        $presenter->hook('get_foo', function () {
            return 'bar';
        });

        $this->assertEquals('bar', $presenter->foo);
    }

    public function testCanAccessRegularHooks()
    {
        $presenter = new Presenter(new ObjectStub());

        $presenter->hook('bar', function () {
            return 'baz';
        });

        $this->assertEquals('baz', $presenter->bar);
    }

    public function testCanAccessArrayValues()
    {
        $presenter = new Presenter(['foo' => 'bar']);

        $this->assertEquals('bar', $presenter->foo);
    }

    public function testBlocksDeadEnds()
    {
        $presenter = new Presenter(new ObjectStub());

        $this->expectException(\Exception::class);

        $presenter->zzz();
    }

    public function testBlocksProtectedMethods()
    {
        $presenter = new Presenter(new ObjectStub());

        $this->expectException(\Exception::class);

        $presenter->delete();
    }

    public function testSupportsToString()
    {
        $presenter = new Presenter(new StringStub());

        $this->assertEquals('test', (string) $presenter);
    }

    public function testSupportsToStringJsonFallback()
    {
        $presenter = new Presenter(['foo' => 'bar']);

        $this->assertEquals(json_encode(['foo' => 'bar']), (string) $presenter);
    }

    public function testReturnsNullByDefault()
    {
        $presenter = new Presenter(new ObjectStub());

        $this->assertNull($presenter->zzzzz);
    }
}

class PresenterStub extends Presenter
{
    protected $secret = true;

    protected $fooBar = 'baz';

    public function isSecret()
    {
        return $this->secret;
    }

    public function getFooBar()
    {
        return $this->fooBar;
    }

    public function presenterMethod()
    {
        return 'presenter.method';
    }
}

class ObjectStub
{
    use Hookable;

    protected $protected = true;

    public $publicValue = 'public';

    protected $protectedValue = 'protected';

    public function isProtected()
    {
        return $this->protected;
    }

    public function getProtectedValue()
    {
        return $this->protectedValue;
    }

    public function publicMethod()
    {
        return 'public';
    }
}

class StringStub
{

    public function __toString()
    {
        return 'test';
    }
}
