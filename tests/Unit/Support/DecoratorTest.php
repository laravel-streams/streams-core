<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Facades\Decorator;

/**
 * @todo replace EntryModel with mock?
 *
 * Class DecoratorTest
 */
class DecoratorTest extends TestCase
{

    public function testCanDecoratePresentables()
    {
        $this->markTestIncomplete();
        /*
        $decorator = app(Decorator::class);
        $this->assertInstanceOf(
            EntryPresenter::class,
            $decorator->decorate(new EntryModel())
        );
        */
    }

    public function testCanUndecoratePresentables()
    {
        $this->markTestIncomplete();
        /*
        $decorator = app(Decorator::class);
        $this->assertInstanceOf(
            EntryModel::class,
            $decorator->undecorate(new EntryPresenter(new EntryModel()))
        );
        */
    }

    public function testCanDecorateArrays()
    {
        $this->markTestIncomplete();

        /*
        $decorator = app(Decorator::class);
        $this->assertInstanceOf(
            EntryPresenter::class,
            $decorator->decorate([new EntryModel()])[0]
        );
        */
    }

    public function testCanUnecorateArrays()
    {
        $this->markTestIncomplete();

        /*
        $decorator = app(Decorator::class);
        $this->assertInstanceOf(
            EntryModel::class,
            $decorator->undecorate([new EntryPresenter(new EntryModel())])[0]
        );
        */
    }
}
