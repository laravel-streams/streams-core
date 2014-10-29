<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;

/**
 * Interface EntryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
interface EntryInterface extends ArrayableInterface
{

    /**
     * Get value from field.
     *
     * @param $field
     * @return mixed
     */
    public function getValueFromField($field);

    /**
     * Get the name of a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldName($field);

    /**
     * Get the label for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldLabel($field);

    /**
     * Get the heading for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldHeading($field);

    /**
     * Get the placeholder for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getFieldPlaceholder($field);

    /**
     * Get the type for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getTypeFromField($field);

    /**
     * Get the assignment object for a field.
     *
     * @param $field
     * @return mixed
     */
    public function getAssignmentFromField($field);

}
 