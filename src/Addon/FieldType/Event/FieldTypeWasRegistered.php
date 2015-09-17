<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Event;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class FieldTypeWasRegistered.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType\Event
 */
class FieldTypeWasRegistered
{
    /**
     * The fieldType object.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new FieldTypeWasRegistered instance.
     *
     * @param FieldType $fieldType
     */
    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Get the fieldType object.
     *
     * @return FieldType
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }
}
