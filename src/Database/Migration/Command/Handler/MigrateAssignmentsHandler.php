<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\MigrateAssignments;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Field\FieldManager;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class MigrateAssignmentsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class MigrateAssignmentsHandler
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
     * Create a new MigrateAssignmentsHandler instance.
     *
     * @param FieldManager              $manager
     * @param FieldRepositoryInterface  $fields
     * @param StreamRepositoryInterface $streams
     */
    function __construct(
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
     * @param MigrateAssignments $command
     */
    public function handle(MigrateAssignments $command)
    {
        $migration = $command->getMigration();
        $stream    = $command->getStream() ?: $migration->getStream();
        $fields    = $command->getFields() ?: $migration->getAssignments();

        if (!$fields) {
            return;
        }

        $addon = $migration->getAddon();

        $stream = $this->streams->findBySlugAndNamespace(
            array_get($stream, 'slug'),
            array_get($stream, 'namespace', $addon->getSlug())
        );

        foreach ($fields as $field => $assignment) {

            if (is_numeric($field)) {
                $field      = $assignment;
                $assignment = [];
            }

            $assignment['label']        = array_get($assignment, 'label', $addon->getNamespace("field.{$field}.label"));
            $assignment['instructions'] = array_get(
                $assignment,
                'instructions',
                $addon->getNamespace("field.{$field}.instructions")
            );

            $field = $this->fields->findBySlugAndNamespace($field, $stream->getNamespace());

            if ($field) {
                $this->manager->assign($field, $stream, $assignment);
            }
        }
    }
}
