<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentPresenter;

class EntryPresenter extends EloquentPresenter
{

    public function __get($key)
    {
        return $this->resource->getValueFromField($key);
    }
}
