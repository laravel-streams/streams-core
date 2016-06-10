<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

/**
 * Class ReorderActionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Reorder extends ActionHandler implements SelfHandling
{

    /**
     * Save the order of the entries.
     *
     * @param TableBuilder $builder
     * @param Request      $request
     */
    public function handle(TableBuilder $builder, Request $request)
    {
        $count = 0;

        $model = $builder->getTableModel();

        /* @var EloquentModel $entry */
        foreach ($request->get($builder->getTableOption('prefix') . 'order', []) as $k => $id) {

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
             * Update the sort order and save.
             */
            if ($entry) {

                $entry->sort_order = $k + 1;

                $entry->save();

                $count++;
            }
        }

        $builder->fire('reordered', compact('count', 'builder'));

        $this->messages->success(trans('streams::message.reorder_success', compact('count')));
    }
}
