<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

/**
 * Class FieldTypeModifier
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeModifier
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
     * Modify the value for database storage.
     *
     * @param  $value
     * @return mixed
     */
    public function modify($value)
    {
        if (!$this->needsModifying($value)) {
            return $value;
        }

        return $value;
    }

    /**
     * Restore the value from storage format.
     *
     * @param  $value
     * @return mixed
     */
    public function restore($value)
    {
        if (!$this->needsRestoring($value)) {
            return $value;
        }

        return $value;
    }

    /**
     * Return whether the value
     * needs to be modified.
     *
     * @param $value
     * @return bool
     */
    protected function needsModifying($value)
    {
        return $value !== null;
    }

    /**
     * Return whether the value
     * needs to be restored.
     *
     * @param $value
     * @return bool
     */
    protected function needsRestoring($value)
    {
        return $value !== null;
    }
}
