<?php

namespace Anomaly\Streams\Platform\Ui\Support;

use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;

/**
 * Class Processor
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Processor
{
    use Macroable;
    use FiresCallbacks;

    /**
     * The instance builder.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Create a new class instance.
     *
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Resolve an attribute value.
     *
     * @param string $attribute
     */
    public function resolve($attribute)
    {
        $resolved = resolver(
            $this->builder->{$attribute},
            ['builder' => $this->builder]
        );

        $this->builder->{$attribute} = evaluate(
            $resolved ?: $this->builder->{$attribute},
            ['builder' => $this->builder]
        );
    }
}
