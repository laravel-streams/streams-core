<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

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
     * @param TreeBuilder $builder
     */
    public function handle(TreeBuilder $builder)
    {
        if ($builder->options instanceof Collection) {

            $builder->tree->options = $builder->options;

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
            $builder->tree->options = new Collection;
        }
    }
}
