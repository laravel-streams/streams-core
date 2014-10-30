<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;
use Anomaly\Streams\Platform\Assignment\AssignmentService;

class DropAssignmentColumnCommandHandler
{

    protected $schema;

    protected $service;

    function __construct(AssignmentSchema $schema, AssignmentService $service)
    {
        $this->schema  = $schema;
        $this->service = $service;
    }

    public function handle(DropAssignmentColumnCommand $command)
    {
        $assignment = $command->getAssignment();

        $fieldType = $this->service->buildFieldType($assignment);

        $table      = $assignment->stream->getEntryTableName();
        $columnName = $fieldType->getColumnName();

        $this->schema->dropColumn($table, $columnName);

        if ($assignment->stream->is_translatable and $assignment->is_translatable) {

            $table = $assignment->stream->getEntryTranslationsTableName();

            $this->schema->dropColumn($table, $columnName);
        }
    }
}
 