<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
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
    protected $fieldType;

    /**
     * Create a new FieldTypeQuery instance.
     *
     * @param FieldType $fieldType
     */
    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * Filter a query by the value of a
     * field using this field type.
     *
     * @param  Builder $query
     * @param          $value
     */
    public function filter(Builder $query, FilterInterface $filter)
    {
        $query->where($this->fieldType->getColumnName(), 'LIKE', "%" . $filter->getValue() . "%");
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
        $query->orderBy($this->fieldType->getColumnName(), $direction);
    }
}
