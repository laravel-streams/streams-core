<?php namespace Anomaly\Streams\Platform\Support;

use Foo\Bar\Baz;
use Foo\Bar\FooBar;

class TransformerTest extends \PHPUnit_Framework_TestCase
{
    protected static $transformer;

    public static function setUpBeforeClass()
    {
        self::$transformer = new Transformer();
    }

    public function testItCanTransformToHandler()
    {
        $matchClass   = new FooBar();
        $noMatchClass = new Baz();

        $this->assertNull(self::$transformer->toHandler($noMatchClass));
        $this->assertEquals('Foo\Bar\FooBarHandler', self::$transformer->toHandler($matchClass));
    }

    public function testItCanTransformToValidator()
    {
        $matchClass   = new FooBar();
        $noMatchClass = new Baz();

        $this->assertNull(self::$transformer->toValidator($noMatchClass));
        $this->assertEquals('Foo\Bar\FooBarValidator', self::$transformer->toValidator($matchClass));
    }

    public function testItCanTransformToInstaller()
    {
        $matchClass   = new FooBar();
        $noMatchClass = new Baz();

        $this->assertNull(self::$transformer->toInstaller($noMatchClass));
        $this->assertEquals('Foo\Bar\FooBarInstaller', self::$transformer->toInstaller($matchClass));
    }
}
 