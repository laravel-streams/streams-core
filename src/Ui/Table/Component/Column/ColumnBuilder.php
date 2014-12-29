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
     * @var ColumnReader
     */
    protected $reader;

    /**
     * The column factory.
     *
     * @var ColumnFactory
     */
    protected $factory;

    /**
     * Create a new ColumnBuilder instance.
     *
     * @param ColumnReader  $reader
     * @param ColumnFactory $factory
     */
    public function __construct(ColumnReader $reader, ColumnFactory $factory)
    {
        $this->reader  = $reader;
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

        foreach ($builder->getColumns() as $column) {

            $column = $this->reader->standardize($column);
            $column = $this->factory->make($column);

            $columns->push($column);
        }
    }
}
