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
     * The column interpreter.
     *
     * @var ColumnInterpreter
     */
    protected $interpreter;

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
     * The column loader.
     *
     * @var ColumnLoader
     */
    protected $loader;

    /**
     * Create a new ColumnBuilder instance.
     *
     * @param ColumnInterpreter $interpreter
     * @param ColumnEvaluator   $evaluator
     * @param ColumnFactory     $factory
     * @param ColumnLoader      $loader
     */
    function __construct(
        ColumnInterpreter $interpreter,
        ColumnEvaluator $evaluator,
        ColumnFactory $factory,
        ColumnLoader $loader
    ) {
        $this->loader      = $loader;
        $this->factory     = $factory;
        $this->interpreter = $interpreter;
        $this->evaluator   = $evaluator;
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

            $parameters = $this->interpreter->standardize($key, $parameters);
            $parameters = $this->evaluator->process($parameters, $builder);

            $column = $this->factory->make($parameters);

            $this->loader->load($column, $parameters);

            $columns->push($column);
        }
    }
}
