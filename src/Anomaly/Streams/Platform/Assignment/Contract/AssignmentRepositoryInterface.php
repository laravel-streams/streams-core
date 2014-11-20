<?php namespace Anomaly\Streams\Platform\Assignment\Contract;

/**
 * Interface AssignmentRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Contract
 */
interface AssignmentRepositoryInterface
{

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
    );

    /**
     * Delete garbage records.
     *
     * @return mixed
     */
    public function deleteGarbage();
}
 