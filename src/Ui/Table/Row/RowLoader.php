<?php namespace Anomaly\Streams\Platform\Ui\Table\Row;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\Row\Contract\RowInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class RowLoader
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Row
 */
class RowLoader
{

    /**
     * The evaluator.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new RowLoader instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Load the view data for rows.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $rows = array_map(
            function (RowInterface $row) {
                return $row->getTableData();
            },
            $table->getRows()->all()
        );

        $rows = $this->evaluator->evaluate($rows);

        $data->put('rows', $rows);
    }
}
