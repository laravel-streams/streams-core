<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Carbon\Carbon;
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
     * @var EloquentModel
     */
    protected $entry;

    /**
     * Create a new SetMetaInformation instance.
     *
     * @param EloquentModel $entry
     */
    public function __construct(EloquentModel $entry)
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
        if ($this->entry->created_at) {
            $this->entry->updated_at = time();
            $this->entry->updated_by = $auth->id();
        }

        if (!$this->entry->created_at) {
            $this->entry->created_at = time();
            $this->entry->created_by = $auth->id();
        }

        if (!$this->entry->sort_order) {

            /* @var Builder $query */
            $query = $this->entry->newQuery();

            $this->entry->sort_order = $query->count('id') + 1;
        }
    }
}
