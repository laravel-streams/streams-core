<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentObserver;

class EntryObserver extends EloquentObserver
{
    /**
     * Run before saving a record.
     *
     * @param $model
     * @return bool|void
     */
    public function saving($model)
    {
        $model->setMetaAttributes();

        return parent::saving($model);
    }
}
