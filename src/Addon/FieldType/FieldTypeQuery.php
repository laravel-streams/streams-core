<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldTypeQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldTypeQuery
{

    /**
     * The where constraint to use.
     *
     * @var string
     */
    protected $constraint = 'and';

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
     * @param Builder         $query
     * @param Filter $filter
     */
    public function filter(Builder $query, Filter $filter)
    {
        $stream = $filter->stream;
        $entry  = $stream->model->getTable();
        $column = $this->fieldType->getColumnName();
        $field  = $stream->fields->get($filter->field);

        $query->{$this->where()}(
            function (Builder $query) use ($field, $filter, $column, $entry) {
                if (method_exists($this->fieldType, 'getRelation')) {
                    $query->where(
                        "{$entry}.{$column}",
                        $filter->getValue()
                    );
                } else {

                    if ($field->translatable) {
                        $column = $column  . '->' . app()->getLocale();
                    }

                    $query->where(
                        "{$entry}.{$column}",
                        'LIKE',
                        "%{$filter->getValue()}%"
                    );
                }
            }
        );
    }

    /**
     * Return the where clause for the given constraint.
     *
     * @return string
     */
    protected function where()
    {
        return $this->constraint == 'and' ? 'where' : 'orWhere';
    }

    /**
     * Order a query in the given direction
     * by a field using this field type.
     *
     * @param Builder $query
     * @param         $direction
     */
    public function orderBy(Builder $query, $direction)
    {
        $query->orderBy($this->fieldType->getColumnName(), $direction);
    }

    /**
     * Get the constraint.
     *
     * @return string
     */
    public function getConstraint()
    {
        return $this->constraint;
    }

    /**
     * Set the constraint.
     *
     * @param $constraint
     * @return $this
     */
    public function setConstraint($constraint)
    {
        $this->constraint = $constraint;

        return $this;
    }
}
