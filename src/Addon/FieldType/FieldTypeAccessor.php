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
     * Set the value.
     *
     * @param $value
     * @return array
     */
    public function set($value)
    {
        $entry = $this->fieldType->getEntry();

        $attributes = $entry->getAttributes();

        $attributes[$this->fieldType->getColumnName()] = $value;

        $entry->setRawAttributes($attributes);
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function get()
    {
        $entry = $this->fieldType->getEntry();

        $attributes = $entry->getAttributes();

        return array_get($attributes, $this->fieldType->getColumnName());
    }
}
