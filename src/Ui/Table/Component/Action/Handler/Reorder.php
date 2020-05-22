<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ReorderActionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Reorder
{

    /**
     * Save the order of the entries.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $items = $builder->request('order', []);

        $repository = (new EntryRepository())->setModel($model = $builder->actionsTableModel());

        /* @var EloquentModel $entry */
        $repository->withoutEvents(
            function () use ($repository, $items) {
                foreach ($items as $k => $id) {

                    $repository
                        ->newQuery()
                        ->where('id', $id)
                        ->update([
                            'sort_order' => $k + 1,
                        ]);
                }
            }
        );

        $model->fireEvent('updatedMany');

        $count = count($items);

        $builder->fire('reordered', compact('count', 'builder', 'model'));

        $this->messages->success(trans('streams::message.reorder_success', compact('count')));
    }
}
