<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Support\Resolver;
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
     * @param Resolver  $resolver
     * @param Evaluator $evaluator
     * @param TableBuilder $builder
     */
    public function handle(Resolver $resolver, Evaluator $evaluator, TableBuilder $builder)
    {
        $evaluator->evaluate(
            $resolver->resolve($builder->getOptions(), ['builder' => $builder]),
            ['builder' => $builder]
        );

        foreach ($builder->getOptions() as $key => $value) {
            $builder->setTableOption($key, $value);
        }
    }
}
