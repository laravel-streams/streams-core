<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Database\Migration\Command\RollbackAssignments;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class RollbackAssignmentsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackAssignmentsHandler
{

    /**
     * The field repository.
     *
     * @var FieldRepositoryInterface
     */
    protected $fields;

    /**
     * The stream repository.
     *
     * @var StreamRepositoryInterface
     */
    protected $streams;

    /**
     * The assignment repository.
     *
     * @var AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new RollbackAssignmentsHandler instance.
     *
     * @param FieldRepositoryInterface      $fields
     * @param StreamRepositoryInterface     $streams
     * @param AssignmentRepositoryInterface $assignments
     */
    public function __construct(
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams,
        AssignmentRepositoryInterface $assignments
    ) {
        $this->fields      = $fields;
        $this->streams     = $streams;
        $this->assignments = $assignments;
    }

    /**
     * Handle the command.
     *
     * @param RollbackAssignments $command
     */
    public function handle(RollbackAssignments $command)
    {
        $migration = $command->getMigration();

        $addon  = $migration->getAddon();
        $fields = $migration->getAssignments();
        $stream = $migration->getStream();

        $namespace = array_get($stream, 'namespace', $migration->getNamespace());
        $slug      = array_get($stream, 'slug', $addon ? $addon->getSlug() : null);

        $stream = $this->streams->findBySlugAndNamespace($slug, $namespace);

        foreach ($fields as $field => $assignment) {

            if (is_numeric($field)) {
                $field = $assignment;
            }

            if ($stream && $field = $this->fields->findBySlugAndNamespace($field, $namespace)) {
                $this->assignments->unassign($field, $stream);
            }
        }

        $this->assignments->cleanup();
    }
}
