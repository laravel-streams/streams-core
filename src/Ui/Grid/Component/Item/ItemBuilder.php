<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Component\Item;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Grid\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Grid\Component\Item;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

/**
 * Class ItemBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ItemBuilder
{

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
     * Create a new ItemBuilder instance.
     *
     * @param ButtonBuilder $buttons
     * @param ItemFactory   $factory
     */
    public function __construct(ButtonBuilder $buttons, ItemFactory $factory)
    {
        $this->buttons   = $buttons;
        $this->factory   = $factory;
    }

    /**
     * Build the items.
     *
     * @param GridBuilder $builder
     */
    public function build(GridBuilder $builder)
    {
        foreach ($builder->getGridEntries() as $entry) {

            $buttons = $this->buttons->build($builder, $entry);

            $buttons = $buttons->enabled();

            $value = valuate($builder, $entry);

            $id = $entry->getKey();

            $item = compact('builder', 'buttons', 'entry', 'value', 'id');

            $item = evaluate($item, compact('builder', 'entry'));

            $builder->addGridItem($this->factory->make($item));
        }
    }
}
