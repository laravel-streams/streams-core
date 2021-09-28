<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Illuminate\Support\Collection;
use Illuminate\Routing\ResponseFactory;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;

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
     * @param TableBuilder    $builder
     * @param ResponseFactory $response
     * @param array           $selected
     */
    public function handle(TableBuilder $builder, ResponseFactory $response, array $selected)
    {
        $model  = $builder->getTableModel();
        $stream = $builder->getTableStream();

        ob_start();

        $headers = [
            'Content-Disposition' => 'attachment; filename=' . $stream->getSlug() . '.csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Pragma'              => 'public',
            'Expires'             => '0',
        ];

        $callback = function () use ($selected, $model, $builder) {
            
            $output = fopen('php://output', 'w');

            $query = $model->newQuery();

            $builder->fire('querying', compact('query'));

            /* @var EloquentModel $entry */
            foreach ($query->get() as $k => $entry) {
                
                $data = new Collection($entry->toArray());

                $builder->fire('exporting', compact('data'));

                if ($k == 0) {
                    fputcsv($output, $data->keys()->all());
                }

                fputcsv($output, array_map(function($value) {

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
