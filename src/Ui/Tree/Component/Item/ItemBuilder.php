<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item;

use Anomaly\Streams\Platform\Ui\Tree\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Tree\Component\Segment\SegmentBuilder;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

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
     * Build the items.
     *
     * @param TreeBuilder $builder
     */
    public static function build(TreeBuilder $builder)
    {
        $factory = app(ItemFactory::class);

        foreach ($builder->getTreeEntries() as $entry) {

            $segments = SegmentBuilder::build($builder, $entry);
            $buttons  = ButtonBuilder::build($builder, $entry);

            $buttons = $buttons->enabled();

            $id     = $entry->getKey();
            $parent = $entry->{$builder->getTreeOption('parent_segment', 'parent_id')};

            $item = compact('builder', 'segments', 'buttons', 'entry', 'parent', 'id');

            $item = evaluate($item, compact('builder', 'entry'));

            $builder->addTreeItem($factory->make($item));
        }
    }
}
