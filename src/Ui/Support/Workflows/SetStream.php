<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class SetStream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetStream
{

    /**
     * Handle the step.
     * 
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        if ($builder->stream instanceof StreamInterface) {

            $builder->instance->stream = $builder->stream;

            return;
        }

        $builder->stream = Streams::try($builder->stream);

        $builder->instance->stream = $builder->stream;
    }
}
