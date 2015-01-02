<?php namespace Anomaly\Streams\Platform\Field;

use Laracasts\Commander\CommanderTrait;

/**
 * Class FieldManager
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldManager
{

    use CommanderTrait;

    /**
     * Create a field.
     *
     * @param  array $field
     * @return mixed
     */
    public function create(array $field)
    {
        return $this->execute('\Anomaly\Streams\Platform\Field\Command\CreateFieldCommand', $field);
    }

    /**
     * Delete a field.
     *
     * @param  $namespace
     * @param  $slug
     * @return mixed
     */
    public function delete($namespace, $slug)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Field\Command\DeleteFieldCommand',
            compact('namespace', 'slug')
        );
    }

    /**
     * Assign a field.
     *
     * @param        $namespace
     * @param        $stream
     * @param        $field
     * @param  array $assignment
     * @return mixed
     */
    public function assign($namespace, $stream, $field, array $assignment)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Field\Command\AssignFieldCommand',
            array_merge($assignment, compact('namespace', 'stream', 'field'))
        );
    }

    /**
     * Unassign a field.
     *
     * @param  $namespace
     * @param  $stream
     * @param  $field
     * @return mixed
     */
    public function unassign($namespace, $stream, $field)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Field\Command\UnassignFieldCommand',
            compact('namespace', 'stream', 'field')
        );
    }
}
