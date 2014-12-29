<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;

/**
 * Class ColumnFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnFactory
{

    /**
     * The default column class.
     *
     * @var string
     */
    protected $column = 'Anomaly\Streams\Platform\Ui\Table\Component\Column\Column';

    /**
     * Make a column.
     *
     * @param  array $parameters
     * @return ColumnInterface
     */
    public function make(array $parameters)
    {
        $column = app()->make(array_get($parameters, 'column', $this->column), $parameters);

        $this->hydrate($column, $parameters);

        return $column;
    }

    /**
     * Hydrate the column with it's remaining parameters.
     *
     * @param ColumnInterface $column
     * @param array           $parameters
     */
    protected function hydrate(ColumnInterface $column, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($column, $method)) {
                $column->{$method}($value);
            }
        }
    }
}
