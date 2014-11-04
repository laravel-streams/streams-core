<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableFilterInterface;

/**
 * Class FieldTypeFilter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeFilter implements TableFilterInterface
{

    /**
     * The parent field type object.
     *
     * @var
     */
    protected $type;

    /**
     * Create a new FieldTypeFilter instance.
     *
     * @param FieldType $type
     */
    function __construct(FieldType $type)
    {
        $this->type = $type;
    }

    /**
     * Handle the filter query.
     *
     * @param $query
     * @param $value
     * @return mixed
     */
    public function handle($query, $value)
    {
        return $query->where($this->type->getColumnName(), 'LIKE', "%{$value}%");
    }
}
 