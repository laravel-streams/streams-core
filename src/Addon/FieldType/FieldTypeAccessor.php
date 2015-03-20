<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Model\EloquentModel;

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
     * @param EloquentModel $entry
     * @param               $value
     * @return array
     */
    public function set(EloquentModel $entry, $value)
    {
        $attributes = $entry->getAttributes();

        $attributes[$this->fieldType->getColumnName()] = $value;

        $entry->setRawAttributes($attributes);
    }

    /**
     * Get the value.
     *
     * @param EloquentModel $entry
     * @return mixed
     */
    public function get(EloquentModel $entry)
    {
        $attributes = $entry->getAttributes();

        return array_get($attributes, $this->fieldType->getColumnName());
    }
}
