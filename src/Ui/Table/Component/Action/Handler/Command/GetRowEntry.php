<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GetRowEntry
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Command
 */
class GetRowEntry implements SelfHandling
{

    /**
     * The entry ID.
     *
     * @var string|int
     */
    protected $id;

    /**
     * The entry model.
     *
     * @var Model
     */
    protected $model;

    /**
     * Create a new GetRowEntry instance.
     *
     * @param int|string $id
     * @param Model      $model
     */
    public function __construct($id, Model $model)
    {
        $this->id    = $id;
        $this->model = $model;
    }

    /**
     * Handle the command.
     *
     * @return mixed
     */
    public function handle()
    {

        /**
         * If it's a standard key we can just
         * use the regular find method.
         */
        if (is_numeric($this->id)) {
            return $this->model->find($this->id);
        }

        /**
         * If there is an alternative key we can
         * use that too by splitting it's key / name.
         */
        if (strstr($this->id, ':')) {

            $ids  = explode(':', $this->id);
            $keys = explode(':', $this->model->getKeyName());

            $query = $this->model->newQuery();

            foreach ($ids as $key => $id) {
                $query->where($keys[$key], $id);
            }

            return $query->first();
        }

        return null;
    }

}
