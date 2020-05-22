<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Illuminate\Routing\ResponseFactory;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class Export
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Export
{

    /**
     * Export the selected entries.
     *
     * @param TableBuilder    $builder
     * @param ResponseFactory $response
     * @param array           $selected
     */
    public function handle(TableBuilder $builder, ResponseFactory $response, array $selected)
    {
        $model  = $builder->actionsTableModel();
        $stream = $builder->stream;

        $headers = [
            'Content-Disposition' => 'attachment; filename=' . $stream->slug . '.csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Pragma'              => 'public',
            'Expires'             => '0',
        ];

        $callback = function () use ($selected, $model) {
            $output = fopen('php://output', 'w');

            /* @var EloquentModel $entry */
            foreach ($selected as $k => $id) {
                if ($entry = $model->find($id)) {
                    if ($k == 0) {
                        fputcsv($output, array_keys($entry->toArray()));
                    }

                    fputcsv($output, $entry->toArray());
                }
            }

            fclose($output);
        };

        $builder->table->response = $response->stream($callback, 200, $headers);
    }
}
