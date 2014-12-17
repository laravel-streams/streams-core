<?php namespace Anomaly\Streams\Platform\Ui\Table\Row;

use Anomaly\Streams\Platform\Ui\Table\Row\Contract\RowInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class RowData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row
 */
class RowData
{

    /**
     * Make the row data.
     *
     * @param TableBuilder $builder
     */
    public function make(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $rows = array_map(
            function (RowInterface $row) {
                return $row->getTableData();
            },
            $table->getRows()->all()
        );

        $data->put('rows', $rows);
    }
}
