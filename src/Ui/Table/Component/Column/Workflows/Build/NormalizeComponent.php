<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnProcessor;

/**
 * Class NormalizeComponent
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeComponent
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        (new ColumnProcessor($builder))->normalize();
    }
}
