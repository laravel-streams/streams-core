<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Exception;

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
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        if ($builder->options instanceof Collection) {

            $builder->instance->options = $builder->options;

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
            try {
                $builder->instance->options = new Collection();
            } catch(Exception $e) {
                dd($e->getMessage());
            }
        }
    }
}
