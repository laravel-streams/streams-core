<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Build;

use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Grid\Grid;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Grid\Component\Item\ItemCollection;
use Anomaly\Streams\Platform\Ui\Grid\Component\Segment\SegmentCollection;

/**
 * Class MakeGrid
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class MakeGrid
{

    /**
     * Handle the step.
     * 
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
    {
        if ($builder->grid instanceof Grid) {
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
            'items' => new ItemCollection(),
        ];

        /**
         * Default to configured.
         */
        if ($builder->grid) {
            // @todo leave grid along - rename ->grid to ->instance
            $builder->grid = $builder->instance = App::make($builder->grid, compact('attributes'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->grid) {
            $builder->grid = App::make(Grid::class, compact('attributes'));
        }
    }
}
