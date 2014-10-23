<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\EntryGenerator;
use Anomaly\Streams\Platform\Model\EloquentObserver;

class StreamObserver extends EloquentObserver
{
    /**
     * Create a new StreamObserver instance.
     */
    public function __construct()
    {
        $this->generator = new EntryGenerator;
    }

    /**
     * Run before creating a record.
     *
     * @param $model
     */
    public function creating($model)
    {
    }

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
        parent::saved($model);
    }

    /**
     * Run before updating a record.
     *
     * @param $model
     * @return bool|void
     */
    public function updating($model)
    {
        parent::updating($model);
    }

    /**
     * Called after deleting a record.
     *
     * @param $model
     */
    public function deleted($model)
    {
        parent::deleted($model);
    }
}
