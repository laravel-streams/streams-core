<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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
     * @param EntryInterface $model
     * @return bool
     */
    public function saving($model)
    {
        $model->touchMeta();

        return parent::saving($model);
    }
}
