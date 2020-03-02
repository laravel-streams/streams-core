<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SetMetaInformation
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetMetaInformation
{

    /**
     * The entry object.
     *
     * @var Model
     */
    protected $entry;

    /**
     * Create a new SetMetaInformation instance.
     *
     * @param Model $entry
     */
    public function __construct(Model $entry)
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
        $this->entry->updated_by_id = $auth->id();

        if (!$this->entry->created_by_id) {
            $this->entry->created_by_id = $auth->id();
        }

        if (!$this->entry->sort_order) {

            /* @var Builder $query */
            $query = $this->entry->newQuery();

            $this->entry->sort_order = $query->count('id') + 1;
        }
    }
}
