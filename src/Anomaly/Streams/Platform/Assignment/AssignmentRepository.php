<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class AssignmentRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment
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
    function __construct(AssignmentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new assignment.
     *
     * @param StreamInterface $stream
     * @param FieldInterface  $field
     * @param                 $label
     * @param                 $placeholder
     * @param                 $instructions
     * @param                 $isUnique
     * @param                 $isRequired
     * @param                 $isTranslatable
     * @return mixed|void
     */
    public function create(
        StreamInterface $stream,
        FieldInterface $field,
        $label,
        $placeholder,
        $instructions,
        $isUnique,
        $isRequired,
        $isTranslatable
    ) {

        $assignment = $this->model->newInstance();

        $assignment->label           = $label;
        $assignment->field_id        = $field->getId();
        $assignment->stream_id       = $stream->getId();
        $assignment->is_unique       = $isUnique;
        $assignment->is_required     = $isRequired;
        $assignment->placeholder     = $placeholder;
        $assignment->instructions    = $instructions;
        $assignment->is_translatable = $isTranslatable;
        $assignment->sort_order      = $this->model->count('id') + 1;

        $assignment->save();
    }

    /**
     * Delete an assignment.
     *
     * @param StreamInterface $stream
     * @param FieldInterface  $field
     * @return mixed
     */
    public function delete(StreamInterface $stream, FieldInterface $field)
    {
        $assignment = $this->model
            ->where('stream_id', $stream->getId())
            ->where('field_id', $field->getId())
            ->first();

        if ($assignment) {

            $assignment->delete();

            return $assignment;
        }

        return null;
    }


    /**
     * Delete garbage records.
     *
     * @return mixed
     */
    public function deleteGarbage()
    {
        return $this->model
            ->table('streams_assignments')
            ->leftJoin('streams_streams', 'streams_assignments.stream_id', '=', 'streams_streams.id')
            ->leftJoin('streams_fields', 'streams_assignments.field_id', '=', 'streams_fields.id')
            ->whereNull('streams_streams.id')
            ->orWhereNull('streams_fields.id')
            ->delete();
    }
}
 