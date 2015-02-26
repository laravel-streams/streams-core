<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Command\MigrateAssignments;
use Anomaly\Streams\Platform\Field\FieldManager;

/**
 * Class MigrateAssignmentsHandler
 *
 * @package Anomaly\Streams\Platform\Stream\Command\Handler
 */
class MigrateAssignmentsHandler
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
     * @param MigrateAssignments $command
     */
    public function handle(MigrateAssignments $command)
    {
        $migration = $command->getMigration();

        $stream = $command->getStream() ?: $migration->getStream();

        $fields = $command->getFields() ?: $migration->getAssignments();

        foreach ($fields as $field => $assignment) {

            $this->assignField($field, $assignment, $stream, $migration->getAddon());
        }
    }

    /**
     * @param       $field
     * @param       $assignment
     * @param array $stream
     * @param Addon $addon
     *
     * @return mixed
     */
    protected function assignField($field, $assignment, array $stream, Addon $addon)
    {
        if (is_string($assignment)) {
            $field = $assignment;
            $assignment = [];
        }

        $unique = (array_get($assignment, 'unique', false));
        $required = (array_get($assignment, 'required', false));
        $translatable = (array_get($assignment, 'translatable', false));

        $label = array_get($assignment, 'label', $addon->getNamespace("field.{$field}.label"));
        $instructions = array_get(
            $assignment,
            'instructions',
            $addon->getNamespace("field.{$field}.instructions")
        );

        $assignment = compact('label', 'instructions', 'unique', 'required', 'translatable');

        $stream = array_get($stream, 'slug');
        $namespace = array_get($stream, 'namespace', $addon->getSlug());

        $this->manager->assign(
            $namespace,
            $stream,
            $field,
            $assignment
        );
    }

}