<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackAssignments;
use Anomaly\Streams\Platform\Field\FieldManager;

/**
 * Class RollbackAssignmentsHandler
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackAssignmentsHandler
{

    /**
     * @var FieldManager
     */
    protected $manager;

    /**
     * @param FieldManager $manager
     */
    public function __construct(FieldManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param RollbackAssignments $command
     */
    public function handle(RollbackAssignments $command)
    {
        $migration = $command->getMigration();

        $fields = $command->getFields() ?: $migration->getAssignments();

        $stream = $command->getStream();

        $namespace = ($stream && $stream->getNamespace()) ? $stream->getNamespace() : $migration->getNamespace();

        $slug = $stream ? $stream->getSlug() : $migration->getAddonSlug();

        foreach ($fields as $field => $assignment) {

            $this->manager->unassign($namespace, $slug, $field, $assignment);
        }
    }

}