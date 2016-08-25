<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Routing\ResponseFactory;

/**
 * Class ExportAll
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class ExportAll extends ActionHandler implements SelfHandling
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

        $headers = [
            'Content-Disposition' => 'attachment; filename=' . $stream->getSlug() . '.csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Pragma'              => 'public',
            'Expires'             => '0'
        ];

        $callback = function () use ($selected, $model) {

            $output = fopen('php://output', 'w');

            /* @var EloquentModel $entry */
            foreach ($model->all() as $k => $entry) {

                if ($k == 0) {
                    fputcsv($output, array_keys($entry->toArray()));
                }

                fputcsv($output, $entry->toArray());
            }

            fclose($output);
        };

        $builder->setTableResponse($response->stream($callback, 200, $headers));
    }
}
