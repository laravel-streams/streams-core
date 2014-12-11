<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Lexicon\Lexicon;

class TagAddonTest extends \PHPUnit_Framework_TestCase
{

    protected static $tag;

    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();

        $provider = new TagServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        self::$tag = app('streams.tag.testable');
    }

    public function testItCanParseAStringIntoAnArray()
    {
        $tag = self::$tag;

        $expected = ['foo' => 'bar', 'baz' => 'boo'];
        $actual   = $tag->parse('foo=bar|baz=boo');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanSetAndGetAttributes()
    {
        $tag = self::$tag;

        $expected = $attributes = ['foo', 'bar'];
        $actual   = $tag->setAttributes($attributes)->getAttributes();

        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetAttribute()
    {
        $tag = self::$tag;

        $tag->setAttributes(['foo' => 'bar']);

        $this->assertEquals('bar', $tag->getAttribute('foo'));

        $tag->setAttributes(['foo', 'bar']);

        $this->assertEquals('bar', $tag->getAttribute('foo', 1));

        $this->assertEquals('default', $tag->getAttribute('zzz', 5, 'default'));
    }

    public function testItCanSetAndGetContent()
    {
        $tag = self::$tag;

        $this->assertEquals('foo', $tag->setContent('foo')->getContent());
    }

    public function testItCanReturnNewPresenter()
    {
        $tag = self::$tag;

        $expected = 'Anomaly\Streams\Platform\Addon\Tag\TagPresenter';
        $actual   = $tag->newPresenter();

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItReturnsNullForCallsToInvalidMethods()
    {
        $tag = self::$tag;

        $this->assertNull($tag->getResource()->zzzz());
    }

    public function testItSetAndGetPluginName()
    {
        $tag = self::$tag;

        $this->assertEquals('foo', $tag->setPluginName('foo')->getPluginName());
    }

    public function testItCanSetEnvironment()
    {
        $tag = self::$tag;

        $tag->setEnvironment(new Lexicon(app()));

        $this->assertTrue(true);
    }

    public function testItCanGetFilter()
    {
        $tag = self::$tag;

        $this->assertFalse($tag->isFilter('foo'));
    }

    public function testItCanGetParse()
    {
        $tag = self::$tag;

        $this->assertFalse($tag->isParse('foo'));
    }
}
 