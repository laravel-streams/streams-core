<?php namespace Anomaly\Streams\Platform\Assignment\Command\Handler;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;
use Anomaly\Streams\Platform\Assignment\Command\AddAssignmentColumn;

/**
 * Class AddAssignmentColumnHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Command
 */
class AddAssignmentColumnHandler
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
     * @param AddAssignmentColumn $command
     */
    public function handle(AddAssignmentColumn $command)
    {
        $assignment = $command->getAssignment();

        $stream = $assignment->getStream();
        $type   = $assignment->getFieldType();

        $this->schema->addColumn($stream->getEntryTableName(), $type, $assignment);

        if ($assignment->isTranslatable()) {
            $this->schema->addColumn($stream->getEntryTranslationsTableName(), $type, $assignment);
        }
    }
}
