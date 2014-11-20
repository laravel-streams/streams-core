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
    function __construct(AssignmentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new assignment.
     *
     * @param $sortOrder
     * @param $streamId
     * @param $fieldId
     * @param $label
     * @param $placeholder
     * @param $instructions
     * @param $isUnique
     * @param $isRequired
     * @param $isTranslatable
     * @return mixed
     */
    public function create(
        $sortOrder,
        $streamId,
        $fieldId,
        $label,
        $placeholder,
        $instructions,
        $isUnique,
        $isRequired,
        $isTranslatable
    ) {

        $assignment = $this->model->newInstance();

        $assignment->label           = $label;
        $assignment->field_id        = $fieldId;
        $assignment->stream_id       = $streamId;
        $assignment->is_unique       = $isUnique;
        $assignment->sort_order      = $sortOrder;
        $assignment->is_required     = $isRequired;
        $assignment->placeholder     = $placeholder;
        $assignment->instructions    = $instructions;
        $assignment->is_translatable = $isTranslatable;

        $assignment->save();
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
 