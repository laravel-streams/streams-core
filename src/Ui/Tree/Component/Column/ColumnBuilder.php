<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Column;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class ColumnBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Tree\Component\Column
 */
class ColumnBuilder
{

    /**
     * The column reader.
     *
     * @var ColumnInput
     */
    protected $input;

    /**
     * The column value.
     *
     * @var ColumnValue
     */
    protected $value;

    /**
     * The column factory.
     *
     * @var ColumnFactory
     */
    protected $factory;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ColumnBuilder instance.
     *
     * @param ColumnInput   $input
     * @param ColumnValue   $value
     * @param ColumnFactory $factory
     * @param Evaluator     $evaluator
     */
    public function __construct(ColumnInput $input, ColumnValue $value, ColumnFactory $factory, Evaluator $evaluator)
    {
        $this->input     = $input;
        $this->value     = $value;
        $this->factory   = $factory;
        $this->evaluator = $evaluator;
    }

    /**
     * Build the columns.
     *
     * @param TreeBuilder  $builder
     * @param              $entry
     * @return ColumnCollection
     */
    public function build(TreeBuilder $builder, $entry)
    {
        $tree = $builder->getTree();

        $columns = new ColumnCollection();

        if (!$builder->getColumns()) {
            $builder->setColumns(['entry.edit_link']);
        }

        $this->input->read($builder, $entry);

        foreach ($builder->getColumns() as $column) {

            array_set($column, 'entry', $entry);

            $column = $this->evaluator->evaluate($column, compact('entry', 'tree'));

            $column['value'] = $this->value->make($tree, $column, $entry);

            $columns->push($this->factory->make($column));
        }

        return $columns;
    }
}
