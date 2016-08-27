<?php namespace Anomaly\Streams\Platform\Database\Migration\Assignment;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Anomaly\Streams\Platform\Database\Migration\Assignment\AssignmentInput;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;

class AssignmentMigrator
{
    /**
     * The assignment input reader.
     *
     * @var AssignmentInput
     */
    protected $input;

    /**
     * The fields repository.
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
     * Create a new AssignmentMigrator instance.
     *
     * @param AssignmentInput               $input
     * @param FieldRepositoryInterface      $fields
     * @param StreamRepositoryInterface     $streams
     * @param AssignmentRepositoryInterface $assignments
     */
    public function __construct(AssignmentInput $input, FieldRepositoryInterface $fields, StreamRepositoryInterface $streams, AssignmentRepositoryInterface $assignments)
    {
        $this->input       = $input;
        $this->fields      = $fields;
        $this->streams     = $streams;
        $this->assignments = $assignments;
    }

    /**
     * Migrate the migration.
     *
     * @param Migration $migration
     */
    public function migrate(Migration $migration)
    {
        $this->input->read($migration);

        if (!$stream = $migration->getStream()) {
            return;
        }

        $assignments = $migration->getAssignments();

        $stream = $this->streams->findBySlugAndNamespace(
            array_get($stream, 'slug'),
            array_get($stream, 'namespace')
        );

        if (!$stream) {
            return;
        }

        foreach ($assignments as $assignment) {
            if (!$field = $this->fields->findBySlugAndNamespace($assignment['field'], $stream->getNamespace())) {
                return;
            }

            $assignment['field']  = $field;
            $assignment['stream'] = $stream;

            try {
                $this->assignments->create($assignment);
            } catch (\Exception $e) {
                // Shhhh..
            }
        }
    }

    /**
     * Reset the migration.
     *
     * @param Migration $migration
     */
    public function reset(Migration $migration)
    {
        $this->input->read($migration);

        if (!$stream = $migration->getStream()) {
            return;
        }
        
        $assignments = $migration->getAssignments();

        $stream = $this->streams->findBySlugAndNamespace(
            array_get($stream, 'slug'),
            array_get($stream, 'namespace')
        );

        if (!$stream) {
            return;
        }

        foreach ($assignments as $assignment) {
            if (!$field = $this->fields->findBySlugAndNamespace($assignment['field'], $stream->getNamespace())) {
                return;
            }

            $assignment['field']  = $field;
            $assignment['stream'] = $stream;

            if ($assignment = $this->assignments->findByStreamAndField($stream, $field)) {
                $this->assignments->delete($assignment);
            }
        }
    }
}
