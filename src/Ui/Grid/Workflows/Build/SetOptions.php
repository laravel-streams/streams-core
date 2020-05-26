<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Build;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

/**
 * Class SetOptions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetOptions
{

    /**
     * Handle the step.
     * 
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
    {
        if ($builder->options instanceof Collection) {

            $builder->grid->options = $builder->options;

            return;
        }

        /**
         * Default to configured.
         */
        if ($builder->options && is_string($builder->options)) {
            $builder->options = App::make($builder->options, compact('builder'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->options) {
            $builder->grid->options = new Collection;
        }
    }
}
