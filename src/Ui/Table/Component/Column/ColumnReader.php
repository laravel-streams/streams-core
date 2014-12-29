<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

/**
 * Class ColumnReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnReader
{

    /**
     * Standardize column configuration input.
     *
     * @param $column
     * @return array
     */
    public function standardize($column)
    {

        /**
         * If the column is just a string then treat
         * it as the header AND the value.
         */
        if (is_string($column)) {
            $column = [
                'header' => $column,
                'value'  => $column,
            ];
        }

        return $column;
    }
}
