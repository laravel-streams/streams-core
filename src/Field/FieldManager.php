<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Command\AssignField;
use Anomaly\Streams\Platform\Field\Command\CreateField;
use Anomaly\Streams\Platform\Field\Command\DeleteField;
use Anomaly\Streams\Platform\Field\Command\UnassignField;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
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
     * @param  array $attributes
     * @return FieldInterface
     */
    public function create(array $attributes)
    {
        return $this->dispatch(new CreateField($attributes));
    }

    /**
     * @param FieldInterface $field
     */
    public function delete(FieldInterface $field)
    {
        $this->dispatch(new DeleteField($field));
    }

    /**
     * Assign a field to a stream.
     *
     * @param FieldInterface  $field
     * @param StreamInterface $stream
     * @param array           $attributes
     * @return AssignmentInterface
     */
    public function assign(FieldInterface $field, StreamInterface $stream, array $attributes = [])
    {
        return $this->dispatch(new AssignField($field, $stream, $attributes));
    }

    /**
     * Unassign a field from a stream.
     *
     * @param FieldInterface  $field
     * @param StreamInterface $stream
     */
    public function unassign(FieldInterface $field, StreamInterface $stream)
    {
        $this->dispatch(new UnassignField($field, $stream));
    }
}
