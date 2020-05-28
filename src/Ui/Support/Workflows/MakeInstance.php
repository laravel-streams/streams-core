<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Support\Component;

/**
 * Class MakeInstance
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class MakeInstance
{

    /**
     * Handle the step.
     * 
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        if ($builder->instance instanceof Component) {
            return;
        }

        /**
         * Default to configured.
         */
        $builder->instance = App::make($builder->instance, [
            'stream' => $builder->stream,
        ]);
    }
}
