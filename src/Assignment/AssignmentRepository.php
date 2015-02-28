<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class AssignmentRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment
 */
class AssignmentRepository implements AssignmentRepositoryInterface
{

    /**
     * The assignment model.
     *
     * @var AssignmentModel
     */
    protected $model;

    /**
     * Create a new AssignmentRepository interface.
     *
     * @param AssignmentModel $model
     */
    public function __construct(AssignmentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new assignment.
     *
     * @param StreamInterface $stream
     * @param FieldInterface  $field
     * @param array           $attributes
     * @return AssignmentInterface
     */
    public function create(StreamInterface $stream, FieldInterface $field, array $attributes)
    {
        $attributes['field_id']  = $field->getId();
        $attributes['stream_id'] = $stream->getId();

        $attributes['sort_order'] = array_get($attributes, 'sort_order', $this->model->count('id') + 1);

        return $this->model->create($attributes);
    }

    /**
     * Delete an assignment.
     *
     * @param AssignmentInterface $assignment
     */
    public function delete(AssignmentInterface $assignment)
    {
        $assignment->delete();
    }

    /**
     * Find an assignment by stream and field.
     *
     * @param StreamInterface $stream
     * @param FieldInterface  $field
     * @return null|AssignmentInterface
     */
    public function findByStreamAndField(StreamInterface $stream, FieldInterface $field)
    {
        return $this->model->where('stream_id', $stream->getId())->where('field_id', $field->getId())->first();
    }

    /**
     * Delete garbage assignments.
     */
    public function deleteGarbage()
    {
        $this->model
            ->leftJoin('streams_streams', 'streams_assignments.stream_id', '=', 'streams_streams.id')
            ->leftJoin('streams_fields', 'streams_assignments.field_id', '=', 'streams_fields.id')
            ->whereNull('streams_streams.id')
            ->orWhereNull('streams_fields.id')
            ->delete();
    }
}
