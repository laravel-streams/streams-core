<?php namespace Anomaly\Streams\Platform\Assignment\Command\Handler;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;
use Anomaly\Streams\Platform\Assignment\Command\DropAssignmentColumn;

/**
 * Class DropAssignmentColumnHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Command
 */
class DropAssignmentColumnHandler
{

    /**
     * The schema builder.
     *
     * @var \Anomaly\Streams\Platform\Assignment\AssignmentSchema
     */
    protected $schema;

    /**
     * Create a new AddAssignmentColumnHandler instance.
     *
     * @param AssignmentSchema $schema
     */
    public function __construct(AssignmentSchema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Handle the command.
     *
     * @param DropAssignmentColumn $command
     */
    public function handle(DropAssignmentColumn $command)
    {
        $assignment = $command->getAssignment();

        $stream = $assignment->getStream();
        $type   = $assignment->getFieldType();

        if (!$type->getColumnType()) {
            return;
        }

        if (!$assignment->isTranslatable()) {
            $table = $stream->getEntryTableName();
        } else {
            $table = $stream->getEntryTranslationsTableName();
        }

        $this->schema->dropColumn($table, $type);
    }
}
