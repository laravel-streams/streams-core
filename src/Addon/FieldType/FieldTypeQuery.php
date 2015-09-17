<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FieldFilterInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldTypeQuery.
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
     * @param Builder              $query
     * @param FieldFilterInterface $filter
     */
    public function filter(Builder $query, FieldFilterInterface $filter)
    {
        $stream     = $filter->getStream();
        $assignment = $stream->getAssignment($filter->getField());

        $column = $this->fieldType->getColumnName();

        $table        = $stream->getEntryTableName();
        $translations = $stream->getEntryTranslationsTableName();

        if ($assignment->isTranslatable()) {
            $query
                ->join($translations, $translations.'.entry_id', '=', $table.'.id')
                ->where($translations.'.'.$column, 'LIKE', '%'.$filter->getValue().'%')
                ->where('locale', config('app.locale'));
        } else {
            $query->where($column, 'LIKE', '%'.$filter->getValue().'%');
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
}
