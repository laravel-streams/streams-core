<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;
use Anomaly\Streams\Platform\Assignment\AssignmentService;

class AddAssignmentColumnCommandHandler
{
    protected $schema;

    protected $service;

    function __construct(AssignmentSchema $schema, AssignmentService $service)
    {
        $this->schema  = $schema;
        $this->service = $service;
    }

    public function handle(AddAssignmentColumnCommand $command)
    {
        $assignment = $command->getAssignment();

        $fieldType = $this->service->buildFieldType($assignment);

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
 