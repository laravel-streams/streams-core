<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class DeleteActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Delete extends ActionHandler implements SelfHandling
{

    /**
     * Delete the selected entries.
     *
     * @param TableBuilder $builder
     * @param array        $selected
     */
    public function handle(TableBuilder $builder, array $selected)
    {
        $count = 0;

        $model = $builder->getTableModel();

        /* @var EloquentModel $entry */
        foreach ($selected as $id) {

            $entry = null;

            /**
             * If there is an alternative key we can
             * use that too by splitting it's key / name.
             */
            if (strstr($id, ':')) {

                $ids  = explode(':', $id);
                $keys = explode(':', $model->getKeyName());

                $query = $model->newQuery();

                foreach ($ids as $key => $id) {
                    $query->where($keys[$key], $id);
                }

                $entry = $query->first();
            }

            /**
             * If it's a standard key we can just
             * use the regular find method.
             */
            if (is_numeric($id)) {
                $entry = $model->find($id);
            }

            /**
             * Delete the entry!
             */
            if ($entry && $entry->isDeletable() && $entry->delete()) {

                $builder->fire('row_deleted', compact('builder', 'model', 'entry'));

                $count++;
            }
        }

        if ($count) {
            $builder->fire('rows_deleted', compact('count', 'builder', 'model'));
        }

        if ($selected) {
            $this->messages->success(trans('streams::message.delete_success', compact('count')));
        }
    }
}
