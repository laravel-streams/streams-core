<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;

class DropAssignmentColumnCommandHandler
{

    protected $schema;

    function __construct(AssignmentSchema $schema)
    {
        $this->schema  = $schema;
    }

    public function handle(DropAssignmentColumnCommand $command)
    {
        $assignment = $command->getAssignment();

        $fieldType = $assignment->type();

        $table      = $assignment->stream->getEntryTableName();
        $columnName = $fieldType->getColumnName();

        $this->schema->dropColumn($table, $columnName);

        if ($assignment->stream->is_translatable and $assignment->is_translatable) {

            $table = $assignment->stream->getEntryTranslationsTableName();

            $this->schema->dropColumn($table, $columnName);
        }
    }
}
 