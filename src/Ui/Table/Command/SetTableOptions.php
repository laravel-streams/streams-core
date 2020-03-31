<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Support\Facades\Evaluator;
use Anomaly\Streams\Platform\Support\Facades\Resolver;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetTableOptions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetTableOptions
{

    /**
     * Handle the command.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        Evaluator::evaluate(
            Resolver::resolve($builder->getOptions(), ['builder' => $builder]),
            ['builder' => $builder]
        );

        foreach ($builder->getOptions() as $key => $value) {
            $builder->setTableOption($key, $value);
        }
    }
}
