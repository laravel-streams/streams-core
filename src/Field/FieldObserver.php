<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\Event\FieldWasCreated;
use Anomaly\Streams\Platform\Field\Event\FieldWasDeleted;
use Anomaly\Streams\Platform\Field\Event\FieldWasSaved;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class FieldObserver
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldObserver extends Observer
{

    /**
     * Run after a record is created.
     *
     * @param FieldInterface $model
     */
    public function created(FieldInterface $model)
    {
        $model->flushCache();

        $this->events->fire(new FieldWasCreated($model));
    }

    /**
     * Run after saving a record.
     *
     * @param FieldInterface $model
     */
    public function saved(FieldInterface $model)
    {
        $model->compileStreams();
        $model->flushCache();

        $this->events->fire(new FieldWasSaved($model));
    }

    /**
     * Run after a record has been deleted.
     *
     * @param FieldInterface $model
     */
    public function deleted(FieldInterface $model)
    {
        $model->deleteAssignments();
        $model->flushCache();

        $this->events->fire(new FieldWasDeleted($model));
    }
}
