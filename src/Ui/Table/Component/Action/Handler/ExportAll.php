<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Routing\ResponseFactory;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQuery;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery;

/**
 * Class ExportAll
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExportAll extends ActionHandler
{

    /**
     * ExportAll the selected entries.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     * @param \Illuminate\Routing\ResponseFactory $response
     * @param \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterQuery $filterApplicator
     * @param \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewQuery $viewApplicator
     */
    public function handle(TableBuilder $builder, ResponseFactory $response, FilterQuery $filterApplicator, ViewQuery $viewApplicator)
    {
        $model  = $builder->getTableModel();
        $stream = $builder->getTableStream();
        $filters = $builder->getActiveTableFilters();

        $filename = $stream->getSlug();

        if ($view = $builder->getActiveTableView()) {
            $filename = $filename . '-' . Str::slug($view->getText(), '_');
        }

        if ($filters->isNotEmpty()) {
            $filename = $filename . '-filtered';
        }

        ob_start();

        $headers = [
            'Content-Disposition' => 'attachment; filename=' . $filename . '.csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Pragma'              => 'public',
            'Expires'             => '0',
        ];

        $callback = function () use ($model, $filters, $builder, $filterApplicator, $viewApplicator) {

            $output = fopen('php://output', 'w');

            $query = $model->newQuery();

            $builder->fire('querying', compact('query'));

            foreach ($filters as $filter) {
                $filterApplicator->filter($builder, $filter, $query);
            }

            if ($view = $builder->getActiveTableView()) {
                $viewApplicator->handle($builder, $query, $view);
            }

            /* @var EloquentModel $entry */
            foreach ($query->get() as $k => $entry) {

                $data = new Collection($entry->toArray());

                $builder->fire('exporting', compact('data'));

                if ($k == 0) {
                    fputcsv($output, $data->keys()->all());
                }

                fputcsv($output, array_map(function ($value) {

                    if (is_array($value)) {
                        return json_encode($value);
                    }

                    return $value;
                }, $data->values()->all()));

                ob_flush();
            }

            fclose($output);
        };

        ob_flush();

        $builder->setTableResponse($response->stream($callback, 200, $headers));
    }
}
