<?php

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Decorator;

class DecoratorTest extends TestCase
{

    public function testCanDecorate()
    {
        $this->assertInstanceOf(
            EntryPresenter::class,
            Decorator::decorate(new EntryModel())
        );
    }

    public function testCanUndecorate()
    {
        $this->assertInstanceOf(
            EntryModel::class,
            Decorator::undecorate(new EntryPresenter(new EntryModel()))
        );
    }
}
