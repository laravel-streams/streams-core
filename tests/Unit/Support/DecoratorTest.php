<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Facades\Decorator;

class DecoratorTest extends TestCase
{

    public function testCanDecoratePresentables()
    {
        $this->assertInstanceOf(
            EntryPresenter::class,
            Decorator::decorate(new EntryModel())
        );
    }

    public function testCanUnecoratePresentables()
    {
        $this->assertInstanceOf(
            EntryModel::class,
            Decorator::undecorate(new EntryPresenter(new EntryModel()))
        );
    }

    public function testCanDecorateArrays()
    {
        $this->assertInstanceOf(
            EntryPresenter::class,
            Decorator::decorate([new EntryModel()])[0]
        );
    }

    public function testCanUnecorateArrays()
    {
        $this->assertInstanceOf(
            EntryModel::class,
            Decorator::undecorate([new EntryPresenter(new EntryModel())])[0]
        );
    }
}
