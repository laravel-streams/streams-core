<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class Export
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler
 */
class Export extends ActionHandler implements SelfHandling
{

    /**
     * Export the selected entries.
     *
     * @param TableBuilder $builder
     * @param array $selected
     */
    public function handle(TableBuilder $builder, array $selected)
    {
        $model  = $builder->getTableModel();
        $stream = $builder->getTableStream();

        /*header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $stream->getSlug() . '.csv');*/

        $headings = array_merge(
            [
                "Created"
            ],
            array_filter(
                array_map(
                    function (AssignmentInterface $assignment) {
                        return trans($assignment->getFieldName());
                    },
                    $stream->getAssignments()->all()
                )
            )
        );

        $output = fopen('php://output', 'w');

        fputcsv($output, $headings);

        /* @var EloquentModel $entry */
        foreach ($selected as $id) {
            if ($entry = $model->find($id)) {

                $data = array_intersect_key(
                    $data,
                    array_flip(
                        array_filter(
                            array_keys($data),
                            function ($key) {

                                if (in_array($key, ['form_field_21', 'form_field_22'])) {
                                    return false;
                                }

                                if (in_array($key, ['entry_date'])) {
                                    return true;
                                }

                                if (strpos($key, 'form_field_') === 0) {
                                    return true;
                                }

                                return false;
                            }
                        )
                    )
                );

                $data['entry_date'] = date('n-j-Y', $data['entry_date']);

                fputcsv($output, $data);
            }
        }

        fclose($output);
    }
}
