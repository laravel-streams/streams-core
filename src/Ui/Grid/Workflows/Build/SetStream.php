<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
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
     * @param GridBuilder $builder
     */
    public function handle(GridBuilder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        if ($builder->stream instanceof StreamInterface) {

            $builder->grid->stream = $builder->stream;

            return;
        }

        $builder->stream = Streams::try($builder->stream);

        $builder->grid->stream = $builder->stream;
    }
}
