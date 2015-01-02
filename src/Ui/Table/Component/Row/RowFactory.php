<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Ui\Table\Component\Row\Contract\RowInterface;

/**
 * Class RowFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Row
 */
class RowFactory
{

    /**
     * Make a row.
     *
     * @param  array $parameters
     * @return RowInterface
     */
    public function make(array $parameters)
    {
        $row = app()->make('Anomaly\Streams\Platform\Ui\Table\Component\Row\Row', $parameters);

        $this->hydrate($row, $parameters);

        return $row;
    }

    /**
     * Hydrate the row with it's remaining parameters.
     *
     * @param RowInterface $row
     * @param array        $parameters
     */
    protected function hydrate(RowInterface $row, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($row, $method)) {
                $row->{$method}($value);
            }
        }
    }
}
