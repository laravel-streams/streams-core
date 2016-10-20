<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Http\Request;

/**
 * Class ReorderActionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Reorder extends ActionHandler
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
            if ($entry = $model->find($id)) {
                $entry->sort_order = $k + 1;

                $entry->save();

                $count++;
            }
        }

        $builder->fire('reordered', compact('count', 'builder'));

        $this->messages->success(trans('streams::message.reorder_success', compact('count')));
    }
}
