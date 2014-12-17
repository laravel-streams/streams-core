<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ColumnLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column
 */
class ColumnLoader
{

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
     * Create a new ColumnLoader instance.
     *
     * @param ColumnReader  $reader
     * @param ColumnFactory $factory
     */
    function __construct(ColumnReader $reader, ColumnFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
    }

    /**
     * Load columns onto a collection.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $columns = $table->getColumns();

        foreach ($builder->getColumns() as $key => $parameters) {

            $parameters = $this->reader->standardize($key, $parameters);

            $column = $this->factory->make($parameters);

            $columns->push($column);
        }
    }
}
