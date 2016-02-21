<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Model\EloquentQueryBuilder;

/**
 * Class EntryQueryBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
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
     * Dynamically handle calls into the query instance.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (ends_with($method, 'FieldType')) {
            return $this->fieldType(
                snake_case(substr_replace($method, '', strrpos($method, 'FieldType'), strlen('FieldType'))),
                $parameters
            );
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Check for field type querying methods.
     *
     * @param string $method
     * @param array  $parameters
     * @return mixed
     */
    public function fieldType($method, $parameters)
    {
        $query = $this->model->getFieldTypeQuery(snake_case($method));

        $method = array_shift($parameters);

        array_unshift($parameters, $this);

        return call_user_func_array([$query, camel_case($method)], $parameters);
    }
}
