<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldTypeQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeQuery
{

    /**
     * The parent field type.
     *
     * @var FieldType
     */
    protected $type;

    /**
     * Create a new FieldTypeQuery instance.
     *
     * @param FieldType $type
     */
    public function __construct(FieldType $type)
    {
        $this->type = $type;
    }

    /**
     * Filter a query by the value of a
     * field using this field type.
     *
     * @param  Builder $query
     * @param          $value
     */
    public function filter(Builder $query, $value)
    {
        $query->where($this->type->getColumnName(), 'LIKE', "%{$value}%");
    }

    /**
     * Order a query in the given direction
     * by a field using this field type.
     *
     * @param  Builder $query
     * @param          $direction
     */
    public function orderBy(Builder $query, $direction)
    {
        $query->orderBy($this->type->getColumnName(), $direction);
    }
}
