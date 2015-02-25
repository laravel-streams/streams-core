<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Entry\EntryModel;

/**
 * Class FieldTypeHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeHandler
{

    /**
     * The parent field type.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new FieldTypeHandler instance.
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
     * @param EntryModel $entry
     * @param            $value
     * @return array
     */
    public function set(EntryModel $entry, $value)
    {
        $attributes = $entry->getAttributes();

        $attributes[$this->fieldType->getColumnName()] = $value;

        $entry->setRawAttributes($attributes);
    }

    /**
     * Get the value.
     *
     * @param EntryModel $entry
     * @return mixed
     */
    public function get($entry)
    {
        $attributes = $entry->getAttributes();

        return array_get($attributes, $this->fieldType->getColumnName());
    }
}
