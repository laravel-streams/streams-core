<?php namespace Anomaly\Streams\Platform\Assignment\Table;

use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class AssignmentTableEntries
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Table
 */
class AssignmentTableEntries
{

    /**
     * Handle the table entries.
     *
     * @param AssignmentTableBuilder    $builder
     * @param StreamRepositoryInterface $streams
     */
    public function handle(AssignmentTableBuilder $builder, StreamRepositoryInterface $streams)
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
