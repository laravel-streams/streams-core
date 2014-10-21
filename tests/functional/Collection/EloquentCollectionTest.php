<?php

use Anomaly\Streams\Platform\Collection\EloquentCollection;

class EloquentCollectionTest extends \PHPUnit_Framework_TestCase
{
    protected function stub()
    {
        return new EloquentCollection([new \Anomaly\Streams\Platform\Model\EloquentModel]);
    }

    public function testItDecoratesModels()
    {
        $collection = $this->stub();

        $this->assertInstanceOf('Anomaly\Streams\Platform\Model\EloquentPresenter', $collection->first());
    }
}
 