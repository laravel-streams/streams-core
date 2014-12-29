<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class ColumnHeader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnHeader
{

    /**
     * Return the column header text.
     *
     * @param Table           $table
     * @param ColumnInterface $column
     * @return null|string
     */
    public function make(Table $table, ColumnInterface $column)
    {
        $header = $column->getHeader();

        $stream = $table->getStream();

        /**
         * If the header is null then the intent was
         * to not have header text at all.
         */
        if ($header === null) {
            return null;
        }

        /**
         * If the header is a closure then return
         * the value from it.
         */
        if ($header instanceof \Closure) {
            return app()->call($header, compact('table'));
        }

        /**
         * If the table is using streams try getting
         * the name from the field for the column.
         */
        if (is_string($header) && $stream instanceof StreamInterface) {

            $field = explode('.', $header);
            $field = end($field);

            if ($field = $stream->getField($field)) {
                return trans($field->getName());
            }
        }

        return trans($header);
    }
}
