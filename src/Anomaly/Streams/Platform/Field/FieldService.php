<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Command\DeleteFieldCommand;
use Anomaly\Streams\Platform\Field\Command\UnassignFieldCommand;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class FieldService
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field
 */
class FieldService
{

    use CommandableTrait;

    /**
     * Create a field.
     *
     * @param array $field
     * @return mixed
     */
    public function create(array $field)
    {
        return $this->execute('Anomaly\Streams\Platform\Field\Command\CreateFieldCommand', $field);
    }

    /**
     * Delete a field.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function delete($namespace, $slug)
    {
        return $this->execute(new DeleteFieldCommand($namespace, $slug));
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
        $data = array_merge($assignment, compact('namespace', 'stream', 'field'));

        return $this->execute('Anomaly\Streams\Platform\Field\Command\AssignFieldCommand', $data);
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
        return $this->execute(new UnassignFieldCommand($namespace, $stream, $field));
    }
}
