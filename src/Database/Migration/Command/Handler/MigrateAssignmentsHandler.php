<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Database\Migration\Command\MigrateAssignments;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
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
     * The assignment repository.
     *
     * @var AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new MigrateAssignmentsHandler instance.
     *
     * @param FieldRepositoryInterface      $fields
     * @param StreamRepositoryInterface     $streams
     * @param AssignmentRepositoryInterface $assignments
     */
    function __construct(
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
     * @param MigrateAssignments $command
     */
    public function handle(MigrateAssignments $command)
    {
        $migration = $command->getMigration();

        $stream = $migration->getStream();
        $fields = $migration->getAssignments();

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

            /**
             * If the label exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($label = array_pull($assignment, 'label')) {
                $assignment = array_add($assignment, config('app.fallback_locale') . '.label', $label);
            }

            /**
             * If the label is not set then make one
             * based on a standardized pattern.
             */
            if (!array_get($assignment, config('app.fallback_locale') . '.label')) {
                $assignment = array_add(
                    $assignment,
                    config('app.fallback_locale') . '.label',
                    $addon ? $addon->getNamespace("field.{$field}.label") : null
                );
            }

            /**
             * If the instructions exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($instructions = array_pull($assignment, 'instructions')) {
                $assignment = array_add($assignment, config('app.fallback_locale') . '.instructions', $instructions);
            }

            /**
             * If the instructions is not set then make one
             * based on a standardized pattern.
             */
            if (!array_get($assignment, config('app.fallback_locale') . '.instructions')) {
                $assignment = array_add(
                    $assignment,
                    config('app.fallback_locale') . '.instructions',
                    $addon ? $addon->getNamespace("field.{$field}.instructions") : null
                );
            }

            /**
             * If the placeholder exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($placeholder = array_pull($assignment, 'placeholder')) {
                $assignment = array_add($assignment, config('app.fallback_locale') . '.placeholder', $placeholder);
            }

            /**
             * If the placeholder is not set then make one
             * based on a standardized pattern.
             */
            if (!array_get($assignment, config('app.fallback_locale') . '.placeholder')) {
                $assignment = array_add(
                    $assignment,
                    config('app.fallback_locale') . '.placeholder',
                    $addon ? $addon->getNamespace("field.{$field}.placeholder") : null
                );
            }

            $field = $this->fields->findBySlugAndNamespace($field, $stream->getNamespace());
            $entry = $this->assignments->findByStreamAndField($stream, $field);

            if ($field && !$entry) {
                $this->assignments->create(array_merge($assignment, compact('field', 'stream')));
            } elseif ($entry) {
                $this->assignments->save($entry->fill($assignment));
            }
        }
    }
}
