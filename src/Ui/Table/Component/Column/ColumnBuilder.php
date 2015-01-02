<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ColumnBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnBuilder
{

    use CommanderTrait;

    /**
     * The column reader.
     *
     * @var ColumnInput
     */
    protected $input;

    /**
     * The column factory.
     *
     * @var ColumnFactory
     */
    protected $factory;

    /**
     * Create a new ColumnBuilder instance.
     *
     * @param ColumnInput   $input
     * @param ColumnFactory $factory
     */
    public function __construct(ColumnInput $input, ColumnFactory $factory)
    {
        $this->input   = $input;
        $this->factory = $factory;
    }

    /**
     * Build the columns.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $columns = $table->getColumns();

        $this->input->read($builder);

        foreach ($builder->getColumns() as $column) {
            $columns->push($this->factory->make($column));
        }
    }
}
