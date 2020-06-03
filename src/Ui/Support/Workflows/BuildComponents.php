<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Exception;

/**
 * Class BuildComponents
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class BuildComponents
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

        $parent = $builder;

        foreach ($builder->{$component} as $key => $parameters) {

            $builder = array_pull($parameters, 'builder', $parent->{$singular . '_builder'});

            $parameters['parent'] = $parent;
            $parameters['stream'] = $parent->stream;

            if (!$builder) {
                throw new Exception("Unknown [{$singular}] builder: [{$builder}] ");
            }

            $builder = (new $builder($parameters))->build();

            $parent->instance->{$component}->put($key, $builder->instance);
        }
    }
}
