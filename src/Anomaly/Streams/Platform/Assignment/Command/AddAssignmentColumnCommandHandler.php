<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;

/**
 * Class AddAssignmentColumnCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Command
 */
class AddAssignmentColumnCommandHandler
{

    /**
     * Handle the command.
     *
     * @param AddAssignmentColumnCommand $command
     */
    public function handle(AddAssignmentColumnCommand $command, AssignmentSchema $schema)
    {
        $assignment = $command->getAssignment();

        $stream = $assignment->getStream();
        $type   = $assignment->getFieldType();

        $table = $stream->getEntryTableName();

        $columnName = $type->getColumnName();
        $columnType = $type->getColumnType();

        if ($columnType) {

            $schema->addColumn($table, $columnName, $columnType);

            if ($assignment->isTranslatable()) {

                $table = $stream->getEntryTranslationsTableName();

                $schema->addColumn($table, $columnName, $columnType);
            }
        }
    }
}
 