<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Support\Parser;
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
        $tree = $builder->getTree();

        $factory = app(SegmentFactory::class);

        $segments = new SegmentCollection();

        SegmentInput::read($builder);

        foreach ($builder->getSegments() as $segment) {

            array_set($segment, 'entry', $entry);

            $segment = evaluate($segment, compact('entry', 'tree'));
            $segment = parse($segment, compact('entry'));

            if (array_get($segment, 'enabled', null) === false) {
                continue;
            }

            $segment['value'] = valuate($tree, $segment, $entry);

            $segments->push($factory->make($segment));
        }

        return $segments;
    }
}
