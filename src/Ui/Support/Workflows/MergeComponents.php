<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        $singular = Str::singular($component);
        
        $parentSegment = Str::studly($builder->component);
        $componentSegment = Str::studly($singular);

        $fallback = "Anomaly\Streams\Platform\Ui\\{$parentSegment}\Component\\{$componentSegment}\\{$componentSegment}Registry";

        $registry = App::make($builder->{$singular . '_registry'} ?: $fallback, compact('builder'));

        $singular = Str::singular($component);

        $components = $builder->{$component};

        foreach ($components as &$parameters) {
            if ($registered = $registry->get(Arr::get($parameters, $singular))) {
                $parameters = array_replace_recursive($registered, Arr::except($parameters, [$singular]));
            }
        }
        
        $builder->{$component} = $components;
    }
}
