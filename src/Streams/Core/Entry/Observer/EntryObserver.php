<?php namespace Streams\Core\Entry\Observer;

use Streams\Core\Model\Observer\EloquentObserver;

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
