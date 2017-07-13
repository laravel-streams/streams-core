<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeQuery;
use Anomaly\Streams\Platform\Model\EloquentQueryBuilder;

/**
 * Class EntryQueryBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryQueryBuilder extends EloquentQueryBuilder
{

    /**
     * The query model.
     *
     * @var EntryModel
     */
    protected $model;

    /**
     * Get a field type criteria.
     *
     * @param $field
     * @return FieldTypeQuery
     */
    public function getFieldTypeCriteria($field)
    {
        return $this->model
            ->getFieldType($field)
            ->getCriteria($this);
    }
}
