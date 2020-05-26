<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
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
     * @param TreeBuilder $builder
     */
    public function handle(TreeBuilder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        if ($builder->stream instanceof StreamInterface) {

            $builder->tree->stream = $builder->stream;

            return;
        }

        $builder->stream = Streams::try($builder->stream);

        $builder->tree->stream = $builder->stream;
    }
}
