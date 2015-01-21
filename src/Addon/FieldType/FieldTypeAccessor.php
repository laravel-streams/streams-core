<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

/**
 * Class FieldTypeAccessor
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeAccessor
{

    /**
     * The parent field type.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new FieldTypeAccessor instance.
     *
     * @param FieldType $fieldType
     */
    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Set the attribute value.
     *
     * @param array $attributes
     * @param       $value
     * @return array
     */
    public function set(array $attributes, $value)
    {
        $attributes[$this->fieldType->getColumnName()] = $value;

        return $attributes;
    }

    /**
     * Get the attribute value.
     *
     * @param array $attributes
     * @return mixed
     */
    public function get(array $attributes)
    {
        return array_get($attributes, $this->fieldType->getColumnName());
    }
}
