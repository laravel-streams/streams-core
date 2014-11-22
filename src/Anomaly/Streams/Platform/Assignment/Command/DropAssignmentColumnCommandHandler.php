<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;

/**
 * Class DropAssignmentColumnCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Command
 */
class DropAssignmentColumnCommandHandler
{

    /**
     * Handle the command.
     *
     * @param DropAssignmentColumnCommand $command
     * @param AssignmentSchema            $schema
     */
    public function handle(DropAssignmentColumnCommand $command, AssignmentSchema $schema)
    {
        $assignment = $command->getAssignment();

        $stream = $assignment->getStream();
        $type   = $assignment->getFieldType();

        $table = $stream->getEntryTableName();

        $columnName = $type->getColumnName();

        $schema->dropColumn($table, $columnName);

        if ($assignment->isTranslatable()) {

            $table = $stream->getEntryTranslationsTableName();

            $schema->dropColumn($table, $columnName);
        }
    }
}
 