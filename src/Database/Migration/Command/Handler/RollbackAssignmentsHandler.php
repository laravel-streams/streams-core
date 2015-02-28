<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackAssignments;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Field\FieldManager;
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
     * The field manager.
     *
     * @var FieldManager
     */
    protected $manager;

    /**
     * Create a new RollbackAssignmentsHandler instance.
     *
     * @param FieldManager              $manager
     * @param FieldRepositoryInterface  $fields
     * @param StreamRepositoryInterface $streams
     */
    public function __construct(
        FieldManager $manager,
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams
    ) {
        $this->fields  = $fields;
        $this->streams = $streams;
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     *
     * @param RollbackAssignments $command
     */
    public function handle(RollbackAssignments $command)
    {
        $migration = $command->getMigration();
        $fields    = $command->getFields() ?: $migration->getAssignments();
        $stream    = $command->getStream() ?: $migration->getStream();

        $namespace = array_get($stream, 'namespace', $migration->getNamespace());
        $slug      = array_get($stream, 'slug', $migration->getAddonSlug());

        $stream = $this->streams->findBySlugAndNamespace($slug, $namespace);

        foreach ($fields as $field => $assignment) {

            if (is_numeric($field)) {
                $field = $assignment;
            }

            if ($stream && $field = $this->fields->findBySlugAndNamespace($field, $namespace)) {
                $this->manager->unassign($field, $stream);
            }
        }
    }
}
