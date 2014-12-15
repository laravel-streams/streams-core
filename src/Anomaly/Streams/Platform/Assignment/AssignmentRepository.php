<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;

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
    public function __construct(AssignmentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new assignment.
     *
     * @param $streamId
     * @param $fieldId
     * @param $label
     * @param $placeholder
     * @param $instructions
     * @param $unique
     * @param $required
     * @param $translatable
     * @return mixed
     */
    public function create(
        $streamId,
        $fieldId,
        $label,
        $placeholder,
        $instructions,
        $unique,
        $required,
        $translatable
    ) {
        $assignment = $this->model->newInstance();

        $assignment->label        = $label;
        $assignment->field_id     = $fieldId;
        $assignment->stream_id    = $streamId;
        $assignment->unique       = $unique;
        $assignment->required     = $required;
        $assignment->placeholder  = $placeholder;
        $assignment->instructions = $instructions;
        $assignment->translatable = $translatable;
        $assignment->sort_order   = $this->model->count('id') + 1;

        $assignment->save();
    }

    /**
     * Delete an assignment.
     *
     * @param $streamId
     * @param $fieldId
     * @return mixed
     */
    public function delete($streamId, $fieldId)
    {
        $assignment = $this->model
            ->where('stream_id', $streamId)
            ->where('field_id', $fieldId)
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
