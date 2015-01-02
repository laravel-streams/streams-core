<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableEntries;
use Laracasts\Commander\CommanderTrait;

/**
 * Class RowBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Row
 */
class RowBuilder
{

    use CommanderTrait;

    /**
     * The entries utility.
     *
     * @var TableEntries
     */
    protected $entries;

    /**
     * The column builder.
     *
     * @var ColumnBuilder
     */
    protected $columns;

    /**
     * The button builder.
     *
     * @var ButtonBuilder
     */
    protected $buttons;

    /**
     * The row factory.
     *
     * @var RowFactory
     */
    protected $factory;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new RowBuilder instance.
     *
     * @param RowFactory    $factory
     * @param ColumnBuilder $columns
     * @param ButtonBuilder $buttons
     * @param Evaluator     $evaluator
     */
    public function __construct(
        RowFactory $factory,
        ColumnBuilder $columns,
        ButtonBuilder $buttons,
        Evaluator $evaluator
    ) {
        $this->factory   = $factory;
        $this->columns   = $columns;
        $this->buttons   = $buttons;
        $this->evaluator = $evaluator;
    }

    /**
     * Build the rows.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $rows  = $table->getRows();

        foreach ($table->getEntries() as $entry) {

            $columns = $this->columns->build($builder, $entry);
            $buttons = $this->buttons->build($builder, $entry);

            $row = compact('columns', 'buttons', 'entry');

            $row = $this->evaluator->evaluate($row, compact('table', 'entry'));

            $rows->push($this->factory->make($row));
        }
    }
}
