<?php namespace Anomaly\Streams\Platform\Field\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;

/**
 * Interface FieldInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Contract
 */
interface FieldInterface
{

    /**
     * Get the ID.
     *
     * @return int
     */
    public function getId();

    /**
     * Get the name.
     *
     * @param null|string $locale
     * @return string
     */
    public function getName($locale = null);

    /**
     * Get the namespace.
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Get the field type.
     *
     * @return FieldType
     */
    public function getType();

    /**
     * Get the configuration.
     *
     * @return mixed
     */
    public function getConfig();

    /**
     * Get the validation rules.
     *
     * @return mixed
     */
    public function getRules();

    /**
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments();

    /**
     * Get the locked flag.
     *
     * @return bool
     */
    public function isLocked();
}
