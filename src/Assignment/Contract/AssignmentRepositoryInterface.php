<?php namespace Anomaly\Streams\Platform\Assignment\Contract;

/**
 * Interface AssignmentRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Contract
 */
interface AssignmentRepositoryInterface
{

    /**
     * Create a new assignment.
     *
     * @param  $streamId
     * @param  $fieldId
     * @param  $label
     * @param  $placeholder
     * @param  $instructions
     * @param  $unique
     * @param  $required
     * @param  $translatable
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
    );

    /**
     * Delete an assignment.
     *
     * @param  $streamId
     * @param  $fieldId
     * @return mixed
     */
    public function delete($streamId, $fieldId);

    /**
     * Delete garbage records.
     *
     * @return mixed
     */
    public function deleteGarbage();
}
