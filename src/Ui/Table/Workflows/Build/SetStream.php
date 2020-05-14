<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Streams\Facades\Streams;
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
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        if ($builder->stream instanceof StreamInterface) {
            return;
        }

        $builder->stream = Streams::try($builder->stream);
    }
}
