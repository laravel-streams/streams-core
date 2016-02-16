<?php namespace Anomaly\Streams\Platform\Assignment\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentSchema;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class RenameAssignmentColumn
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Command
 */
class RenameAssignmentColumn implements SelfHandling
{

    /**
     * The assignment interface.
     *
     * @var AssignmentInterface
     */
    protected $assignment;

    /**
     * Create a new RenameAssignmentColumn instance.
     *
     * @param AssignmentInterface $assignment
     */
    public function __construct(AssignmentInterface $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * Handle the command.
     *
     * @param AssignmentSchema              $schema
     * @param AssignmentRepositoryInterface $assignments
     */
    public function handle(AssignmentSchema $schema, AssignmentRepositoryInterface $assignments)
    {
        $stream = $this->assignment->getStream();
        $type   = $this->assignment->getFieldType(true);

        if (!$this->assignment->isTranslatable()) {
            $table = $stream->getEntryTableName();
        } else {
            $table = $stream->getEntryTranslationsTableName();
        }

        /* @var AssignmentInterface $assignment */
        $assignment = $assignments->find($this->assignment->getId());

        $assignment = clone($assignment);

        $schema->renameColumn($table, $type, $assignment);
    }
}
