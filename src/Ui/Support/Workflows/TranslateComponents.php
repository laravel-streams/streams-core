<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Translation\Translator;
use Anomaly\Streams\Platform\Ui\Support\Builder;

/**
 * Class TranslateComponents
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TranslateComponents
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     * @param string $component
     */
    public function handle(Builder $builder, $component)
    {
        $builder->{$component} = Translator::translate($builder->{$component});
    }
}
