<?php namespace Anomaly\Streams\Platform\Ui\Table\Row;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class RowBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row
 */
class RowBuilder
{

    /**
     * The row factory.
     *
     * @var RowFactory
     */
    protected $factory;

    /**
     * Create a new RowBuilder instance.
     *
     * @param RowFactory $factory
     */
    function __construct(RowFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Load rows onto a collection.
     *
     * @param TableBuilder $builder
     * @param              $entry
     */
    public function load(TableBuilder $builder, $entry)
    {
        $table   = $builder->getTable();
        $columns = $table->getColumns();
        $buttons = $table->getButtons();
        $rows    = $table->getRows();

        $row = $this->factory->make(compact('entry', 'columns', 'buttons'));

        $rows->push($row);
    }
}
