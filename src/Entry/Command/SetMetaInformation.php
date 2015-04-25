<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Query\Builder;

/**
 * Class SetMetaInformation
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class SetMetaInformation implements SelfHandling
{

    /**
     * The entry object.
     *
     * @var EntryModel
     */
    protected $entry;

    /**
     * Create a new SetMetaInformation instance.
     *
     * @param EntryModel $entry
     */
    public function __construct(EntryModel $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Handle the command.
     *
     * @param Guard $auth
     */
    public function handle(Guard $auth)
    {
        /* @var Builder $query */
        $query = $this->entry->newQuery();

        if (!$this->entry->getKey()) {

            $this->entry->updated_at = null;
            $this->entry->created_at = time();
            $this->entry->created_by = $auth->id();
            $this->entry->sort_order = $query->count('id') + 1;
        } else {

            $this->entry->updated_at = time();
            $this->entry->updated_by = $auth->id();
        }
    }
}
