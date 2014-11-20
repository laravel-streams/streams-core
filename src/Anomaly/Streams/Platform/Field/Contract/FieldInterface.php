<?php namespace Anomaly\Streams\Platform\Field\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Interface FieldInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Contract
 */
interface FieldInterface
{

    /**
     * Get the name.
     *
     * @return mixed
     */
    public function getName();

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
     * @return mixed
     */
    public function getAssignments();

    /**
     * Get the locked flag.
     *
     * @return mixed
     */
    public function isLocked();
}
 