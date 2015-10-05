<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Tree\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Tree\Component\Column\ColumnBuilder;
use Anomaly\Streams\Platform\Ui\Tree\Component\Item;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class ItemBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Item
 */
class ItemBuilder
{

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
     * @var ItemFactory
     */
    protected $factory;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ItemBuilder instance.
     *
     * @param ColumnBuilder $columns
     * @param ButtonBuilder $buttons
     * @param ItemFactory   $factory
     * @param Evaluator     $evaluator
     */
    function __construct(
        ColumnBuilder $columns,
        ButtonBuilder $buttons,
        ItemFactory $factory,
        Evaluator $evaluator
    ) {
        $this->columns   = $columns;
        $this->buttons   = $buttons;
        $this->factory   = $factory;
        $this->evaluator = $evaluator;
    }

    /**
     * Build the items.
     *
     * @param TreeBuilder $builder
     */
    public function build(TreeBuilder $builder)
    {
        foreach ($builder->getTreeEntries() as $entry) {

            $columns = $this->columns->build($builder, $entry);
            $buttons = $this->buttons->build($builder, $entry);

            $buttons = $buttons->enabled();

            $id     = $entry->getId();
            $parent = $entry->{$builder->getTreeOption('parent_column', 'parent_id')};

            $item = compact('builder', 'columns', 'buttons', 'entry', 'parent', 'id');

            $item = $this->evaluator->evaluate($item, compact('builder', 'entry'));

            $builder->addTreeItem($this->factory->make($item));
        }
    }
}
