<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Tree\Component\Button\ButtonBuilder;
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
     * The value utility.
     *
     * @var ItemValue
     */
    protected $value;

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
     * @param ItemValue     $value
     * @param ButtonBuilder $buttons
     * @param ItemFactory   $factory
     * @param Evaluator     $evaluator
     */
    function __construct(ItemValue $value, ButtonBuilder $buttons, ItemFactory $factory, Evaluator $evaluator)
    {
        $this->value     = $value;
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

            $buttons = $this->buttons->build($builder, $entry);

            $buttons = $buttons->enabled();

            $value = $this->value->make($builder, $entry);

            $id     = $entry->getId();
            $parent = $entry->{$builder->getTreeOption('parent_column', 'parent_id')};

            $item = compact('builder', 'buttons', 'entry', 'value', 'parent', 'id');

            $item = $this->evaluator->evaluate($item, compact('builder', 'entry'));

            $builder->addTreeItem($this->factory->make($item));
        }
    }
}
