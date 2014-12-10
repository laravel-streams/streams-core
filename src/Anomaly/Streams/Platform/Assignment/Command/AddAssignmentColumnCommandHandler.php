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

    protected $schema;

    function __construct(AssignmentSchema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Handle the command.
     *
     * @param AddAssignmentColumnCommand $command
     */
    public function handle(AddAssignmentColumnCommand $command)
    {
        $assignment = $command->getAssignment();

        $stream = $assignment->getStream();
        $type   = $assignment->getFieldType();

        $table = $stream->getEntryTableName();

        $columnName = $type->getColumnName();
        $columnType = $type->getColumnType();

        if ($columnType) {

            $this->schema->addColumn($table, $columnName, $columnType);

            if ($assignment->isTranslatable()) {

                $table = $stream->getEntryTranslationsTableName();

                $this->schema->addColumn($table, $columnName, $columnType);
            }
        }
    }
}
 