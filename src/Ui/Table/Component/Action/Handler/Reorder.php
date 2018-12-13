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
        $items = $request->get($builder->getTableOption('prefix') . 'order', []);

        $model = $builder->getTableModel();

        /* @var EloquentModel $entry */
        foreach ($items as $k => $id) {

            $model
                ->newQuery()
                ->where('id', $id)
                ->update(
                    [
                        'sort_order' => $k + 1,
                    ]
                );
        }

        $model->flushCache();

        $count = count($items);

        $builder->fire('reordered', compact('count', 'builder'));

        $this->messages->success(trans('streams::message.reorder_success', compact('count')));
    }
}
