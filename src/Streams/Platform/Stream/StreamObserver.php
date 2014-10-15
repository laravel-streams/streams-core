<?php namespace Streams\Platform\Stream;

use Streams\Platform\Entry\EntryGenerator;
use Streams\Platform\Model\EloquentObserver;

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
        $model->newSchema()->create();
    }

    /**
     * Run after saving a record.
     *
     * @param $model
     */
    public function saved($model)
    {
        parent::saved($model);

        $this->generator->compileEntryModel($model);
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

        $model->newSchema()->update();
    }

    /**
     * Called after deleting a record.
     *
     * @param $model
     */
    public function deleted($model)
    {
        parent::deleted($model);

        $model->assignments()->delete();

        $model->newSchema()->delete();
    }
}
