<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Database\Migration\Command\Rollback;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class RollbackHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackHandler
{

    /**
     * The field repository.
     *
     * @var FieldRepositoryInterface
     */
    protected $fields;

    /**
     * The assignment repository.
     *
     * @var AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new RollbackHandler instance.
     *
     * @param FieldRepositoryInterface      $fields
     * @param AssignmentRepositoryInterface $assignments
     */
    function __construct(FieldRepositoryInterface $fields, AssignmentRepositoryInterface $assignments)
    {
        $this->fields      = $fields;
        $this->assignments = $assignments;
    }

    /**
     * Handle the command.
     *
     * @param Rollback $command
     */
    public function handle(Rollback $command)
    {
        $command->getMigration()->unassignFields();
        $command->getMigration()->deleteStream();
        $command->getMigration()->deleteFields();

        $this->fields->deleteGarbage();
        $this->assignments->deleteGarbage();
    }
}
