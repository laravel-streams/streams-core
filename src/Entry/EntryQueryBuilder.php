<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentQueryBuilder;

/**
 * Class EntryQueryBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryQueryBuilder extends EloquentQueryBuilder
{

    /**
     * The query model.
     *
     * @var EntryModel
     */
    protected $model;
}
