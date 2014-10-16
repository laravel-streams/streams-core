<?php namespace Streams\Platform\Asset;

class AddonPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanReturnResourceName()
    {
        $presenter = app('streams.distributions')->first();

        $this->assertEquals('Base', $presenter->name);
    }

    public function testItCanReturnResourceDescription()
    {
        $presenter = app('streams.distributions')->first();

        $this->assertEquals('The base distribution.', $presenter->description);
    }

    public function testItCanReturnResourceSlug()
    {
        $presenter = app('streams.distributions')->first();

        $this->assertEquals('base', $presenter->slug);
    }
}
