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
    protected $type;

    /**
     * Create a new FieldTypeAccessor instance.
     *
     * @param FieldType $type
     */
    public function __construct(FieldType $type)
    {
        $this->type = $type;
    }

    /**
     * Modify the value.
     *
     * @param  $value
     * @return mixed
     */
    public function modify($value)
    {
        return $value;
    }

    /**
     * Restore the value.
     *
     * @param  $value
     * @return mixed
     */
    public function restore($value)
    {
        return $value;
    }
}
