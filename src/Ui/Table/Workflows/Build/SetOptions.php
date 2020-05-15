<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Streams\Facades\Streams;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->options instanceof Collection) {

            $builder->table->options = $builder->options;

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
            $builder->table->options = new Collection;
        }
    }
}
