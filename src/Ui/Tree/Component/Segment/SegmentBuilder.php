<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SegmentBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentBuilder
{

    /**
     * Build the segments.
     *
     * @param  TreeBuilder $builder
     * @param                    $entry
     * @return SegmentCollection
     */
    public static function build(TreeBuilder $builder, $entry)
    {
        $tree = $builder->tree;

        $factory = app(SegmentFactory::class);

        $segments = new SegmentCollection();

        SegmentInput::read($builder);

        foreach ($builder->segments as $segment) {

            array_set($segment, 'entry', $entry);

            $segment = evaluate($segment, compact('entry', 'tree'));
            $segment = Str::parse($segment, compact('entry'));

            if (array_get($segment, 'enabled', null) === false) {
                continue;
            }

            $segment['value'] = valuate($tree, $segment, $entry);

            $segments->push($factory->make($segment));
        }

        return $segments;
    }
}
