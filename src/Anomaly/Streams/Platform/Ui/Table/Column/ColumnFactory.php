<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

/**
 * Class ColumnFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column
 */
class ColumnFactory
{
    /**
     * The default column class.
     *
     * @var string
     */
    protected $column = 'Anomaly\Streams\Platform\Ui\Table\Column\Column';

    /**
     * Make a column.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (isset($parameters['column']) && class_exists($parameters['column'])) {
            return app()->make($parameters['column'], $parameters);
        }

        return app()->make($this->column, $parameters);
    }
}
