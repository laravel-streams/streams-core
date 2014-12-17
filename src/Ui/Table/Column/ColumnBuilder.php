<?php namespace Anomaly\Streams\Platform\Ui\Table\Column;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ColumnBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column
 */
class ColumnBuilder
{

    /**
     * The column converter.
     *
     * @var ColumnConverter
     */
    protected $converter;

    /**
     * The column evaluator.
     *
     * @var ColumnEvaluator
     */
    protected $evaluator;

    /**
     * The column factory.
     *
     * @var ColumnFactory
     */
    protected $factory;

    /**
     * Create a new ColumnBuilder instance.
     *
     * @param ColumnConverter $converter
     * @param ColumnEvaluator $evaluator
     * @param ColumnFactory   $factory
     */
    function __construct(ColumnConverter $converter, ColumnEvaluator $evaluator, ColumnFactory $factory)
    {
        $this->factory   = $factory;
        $this->converter = $converter;
        $this->evaluator = $evaluator;
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

            $parameters = $this->converter->standardize($key, $parameters);

            $column = $this->factory->make($parameters);

            $columns->push($column);
        }
    }
}
