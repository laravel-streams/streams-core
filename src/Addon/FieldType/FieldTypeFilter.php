<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

/**
 * Class FieldTypeFilter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeFilter
{

    /**
     * The parent field type.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new FieldTypeFilter instance.
     *
     * @param FieldType $fieldType
     */
    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }
}
