<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;

/**
 * Class EntryRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryRepository implements EntryRepositoryInterface
{
    /**
     * The entry model.
     *
     * @var EntryModel
     */
    protected $model;

    /**
     * Create a new EntryRepository instance.
     *
     * @param EntryModel $model
     */
    public function __construct(EntryModel $model)
    {
        $this->model = $model;
    }
}
