<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;

/**
 * Class EntryObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryObserver extends EloquentObserver
{

    /**
     * Before saving an entry touch the
     * meta information.
     *
     * @param EloquentModel $model
     * @return bool
     */
    public function saving(EloquentModel $model)
    {
        $model->touchMeta();

        return parent::saving($model);
    }
}
