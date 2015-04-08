<?php namespace Anomaly\Streams\Platform\Field\Table;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class FieldAssignmentTableEntries
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Table
 */
class FieldAssignmentTableEntries
{

    /**
     * Handle the table entries.
     *
     * @param FieldAssignmentTableBuilder $builder
     * @param StreamRepositoryInterface   $streams
     */
    public function handle(FieldAssignmentTableBuilder $builder, StreamRepositoryInterface $streams)
    {
        $stream = $streams->findBySlugAndNamespace(
            $builder->getTableOption('stream'),
            $builder->getTableOption('namespace')
        );

        $assignments = $stream->getAssignments();

        if ($skip = $builder->getTableOption('skip')) {
            $assignments = $assignments->withoutFields($skip);
        }

        $builder->setTableEntries($assignments);
    }
}
