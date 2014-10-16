<?php namespace Streams\Platform\Asset\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsATag()
    {
        $addon = $this->stub();

        $this->assertEquals('tag', $addon->getType());
    }

    public function testItCanReturnNewPresenter()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Tag\TagPresenter';
        $actual   = get_class($addon->newPresenter());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewServiceProvider()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Tag\TagServiceProvider';
        $actual   = get_class($addon->newServiceProvider());

        $this->assertEquals($expected, $actual);
    }

    public function testItRegistersTagsToLexicon()
    {
        $this->stub()->newServiceProvider()->register();

        $this->assertTrue(true); // No exceptions? Works!
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\Tag\TagAddon(app());
    }
}
