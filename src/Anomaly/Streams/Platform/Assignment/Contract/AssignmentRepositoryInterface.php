<?php namespace Anomaly\Streams\Platform\Assignment\Contract;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
     * @param StreamInterface $stream
     * @param FieldInterface  $field
     * @param                 $label
     * @param                 $placeholder
     * @param                 $instructions
     * @param                 $isUnique
     * @param                 $isRequired
     * @param                 $isTranslatable
     * @return mixed
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
    );

    /**
     * Delete an assignment.
     *
     * @param StreamInterface $stream
     * @param FieldInterface  $field
     * @return mixed
     */
    public function delete(StreamInterface $stream, FieldInterface $field);

    /**
     * Delete garbage records.
     *
     * @return mixed
     */
    public function deleteGarbage();
}
