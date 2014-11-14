<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;

class AddAssignmentColumnCommandHandler
{

    protected $schema;

    function __construct(AssignmentSchema $schema)
    {
        $this->schema = $schema;
    }

    public function handle(AddAssignmentColumnCommand $command)
    {
        $assignment = $command->getAssignment();

        $fieldType = $assignment->type();

        if ($fieldType->getColumnType()) {

            $table      = $assignment->stream->getEntryTableName();
            $columnName = $fieldType->getColumnName();
            $columnType = $fieldType->getColumnType();

            $this->schema->addColumn($table, $columnName, $columnType);

            if ($assignment->stream->is_translatable and $assignment->is_translatable) {

                $table = $assignment->stream->getEntryTranslationsTableName();

                $this->schema->addColumn($table, $columnName, $columnType);
            }
        }
    }
}
 