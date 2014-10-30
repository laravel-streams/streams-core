<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Command\AddFieldCommand;
use Anomaly\Streams\Platform\Field\Command\AssignFieldCommand;
use Anomaly\Streams\Platform\Field\Command\RemoveFieldCommand;
use Anomaly\Streams\Platform\Field\Command\UnassignFieldCommand;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

class FieldService
{

    use CommandableTrait;

    /**
     * Add a field.
     *
     * @param array $field
     * @return mixed
     */
    public function add(array $field)
    {
        $slug      = $field['slug'];
        $type      = $field['type'];
        $namespace = $field['namespace'];

        $name = isset($field['name']) ? $field['name'] : null;

        $rules    = isset($field['rules']) ? $field['rules'] : [];
        $settings = isset($field['settings']) ? $field['settings'] : [];
        $isLocked = isset($field['is_locked']) ? $field['is_locked'] : true;

        $command = new AddFieldCommand($namespace, $slug, $type, $name, $settings, $rules, $isLocked);

        return $this->execute($command);
    }

    /**
     * Remove a field.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function remove($namespace, $slug)
    {
        $command = new RemoveFieldCommand($namespace, $slug);

        return $this->execute($command);
    }

    /**
     * Assign a field.
     *
     * @param       $namespace
     * @param       $stream
     * @param       $field
     * @param array $assignment
     * @return mixed
     */
    public function assign($namespace, $stream, $field, array $assignment)
    {
        // Determine some optional properties.
        $isTranslatable = isset($assignment['is_translatable']) ? $assignment['is_translatable'] : false;
        $isRevisionable = isset($assignment['is_revisionable']) ? $assignment['is_revisionable'] : false;
        $isRequired     = isset($assignment['is_required']) ? $assignment['is_required'] : false;
        $sortOrder      = isset($assignment['sort_order']) ? $assignment['sort_order'] : 0;
        $isUnique       = isset($assignment['is_unique']) ? $assignment['is_unique'] : false;

        $label        = isset($assignment['label']) ? $assignment['label'] : null;
        $placeholder  = isset($assignment['placeholder']) ? $assignment['placeholder'] : null;
        $instructions = isset($assignment['instructions']) ? $assignment['instructions'] : null;

        $command = new AssignFieldCommand(
            $sortOrder,
            $namespace,
            $stream,
            $field,
            $label,
            $placeholder,
            $instructions,
            $isUnique,
            $isRequired,
            $isTranslatable,
            $isRevisionable
        );

        return $this->execute($command);
    }

    /**
     * Unassign a field.
     *
     * @param $namespace
     * @param $stream
     * @param $field
     * @return mixed
     */
    public function unassign($namespace, $stream, $field)
    {
        $command = new UnassignFieldCommand($namespace, $stream, $field);

        return $this->execute($command);
    }
}
