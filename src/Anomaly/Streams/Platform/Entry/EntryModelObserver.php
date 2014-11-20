<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModelObserver;

/**
 * Class EntryModelObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryModelObserver extends EloquentModelObserver
{

    /**
     * Before saving an entry touch the
     * meta information.
     *
     * @param EntryInterface $model
     * @return bool
     */
    public function saving($model)
    {
        $model->touchMeta();

        return parent::saving($model);
    }
}
