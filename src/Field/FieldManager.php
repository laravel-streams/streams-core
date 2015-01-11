<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Command\DeleteField;
use Anomaly\Streams\Platform\Field\Command\UnassignField;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

    /**
     * Create a field.
     *
     * @param  array $field
     * @return mixed
     */
    public function create(array $field)
    {
        return $this->dispatchFromArray('Anomaly\Streams\Platform\Field\Command\CreateFieldCommand', $field);
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
        return $this->dispatch(new DeleteField($namespace, $slug));
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
        return $this->dispatchFromArray(
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
        return $this->dispatch(new UnassignField($namespace, $stream, $field));
    }
}
