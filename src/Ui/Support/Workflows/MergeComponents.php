<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Support\Builder;

/**
 * Class MergeComponents
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MergeComponents
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     * @param string $component
     */
    public function handle(Builder $builder, $component)
    {
        if (!$registry = $builder->{$component . '_registry'}) {
            return;
        }

        $registry = App::make($registry, compact('builder'));

        $components = $builder->{$component};

        foreach ($components as &$parameters) {
            if ($view = $registry->get(array_get($parameters, 'view'))) {
                $parameters = array_replace_recursive($view, array_except($parameters, ['view']));
            }
        }

        $builder->{$component} = $components;
    }
}
