<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Ui\Table\Table;
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
     * @return $this|Builder
     */
    public function filter(Builder $query, $value)
    {
        $query = $query->where($this->type->getColumnName(), 'LIKE', "%{$value}%");

        return $query;
    }

    /**
     * Order a query in the given direction
     * by a field using this field type.
     *
     * @param  Table $table
     * @param        $direction
     */
    public function orderBy(Table $table, $direction)
    {
        $table->setOption('order_by', [$this->type->getColumnName() => $direction]);
    }
}
