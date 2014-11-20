<?php namespace Anomaly\Streams\Platform\Stream\Contract;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;

/**
 * Interface StreamInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Contract
 */
interface StreamInterface
{

    /**
     * Get the namespace.
     *
     * @return mixed
     */
    public function getNamespace();

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug();

    /**
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix();

    /**
     * Get the name.
     *
     * @return mixed
     */
    public function getName();

    /**
     * Get the translatable flag.
     *
     * @return mixed
     */
    public function isTranslatable();

    /**
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments();

    /**
     * Get an assignment by it's field's slug.
     *
     * @param $fieldSlug
     * @return mixed
     */
    public function getAssignment($fieldSlug);

    /**
     * Get a stream field by it's slug.
     *
     * @param $slug
     * @return mixed
     */
    public function getField($slug);

    /**
     * Get a field's type by the field's slug.
     *
     * @param $fieldSlug
     * @return mixed
     */
    public function getFieldType($fieldSlug);
}
 