<?php namespace Streams\Platform\Asset\Theme;

class ThemeCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanReturnActive()
    {
        $collection = $this->stub();

        $collection->first()->setActive(true);

        $this->assertEquals(true, $collection->active()->isActive());
    }

    protected function stub()
    {
        return app('streams.themes');
    }
}
