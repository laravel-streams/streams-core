<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Entry\EntryQueryBuilder;
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
     * @param FilterInterface $filter
     */
    public function filter(Builder $query, FilterInterface $filter)
    {
        $stream     = $filter->getStream();
        $assignment = $stream->getAssignment($filter->getField());

        $column       = $this->fieldType->getColumnName();
        $translations = $stream->getEntryTranslationsTableName();

        if ($assignment->isTranslatable()) {

            if ($query instanceof EntryQueryBuilder && !$query->hasJoin($translations)) {
                $query->joinTranslations();
            }

            $query->{$this->where()}($translations . '.' . $column, 'LIKE', "%" . $filter->getValue() . "%");
        } else {
            $query->{$this->where()}($column, 'LIKE', "%" . $filter->getValue() . "%");
        }
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

    /**
     * Return the where clause for the given constraint.
     *
     * @return string
     */
    protected function where()
    {
        return $this->constraint == 'and' ? 'where' : 'orWhere';
    }
}
