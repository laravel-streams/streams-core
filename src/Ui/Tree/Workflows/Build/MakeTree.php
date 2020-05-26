<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Tree\Tree;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Tree\Component\Segment\SegmentCollection;

/**
 * Class MakeTree
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class MakeTree
{

    /**
     * Handle the step.
     * 
     * @param TreeBuilder $builder
     */
    public function handle(TreeBuilder $builder)
    {
        if ($builder->tree instanceof Tree) {
            return;
        }

        /**
         * Default attributes.
         */
        $attributes = [

            'mode' => null,
            'entry' => null,

            'stream' => $builder->stream,

            'values' => new Collection(),
            'options' => new Collection(),

            'errors' => new MessageBag(),

            'buttons' => new ButtonCollection(),
            'segments' => new SegmentCollection(),
        ];

        /**
         * Default to configured.
         */
        if ($builder->tree) {
            // @todo leave tree along - rename ->tree to ->instance
            $builder->tree = $builder->instance = App::make($builder->tree, compact('attributes'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->tree) {
            $builder->tree = App::make(Tree::class, compact('attributes'));
        }
    }
}
