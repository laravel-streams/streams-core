<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

/**
 * Class ColumnNormalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnNormalizer
{

    /**
     * Normalize the column input.
     *
     * @param array $columns
     * @return array
     */
    public function normalize(array $columns)
    {
        foreach ($columns as &$column) {

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
        }

        return $columns;
    }
}
