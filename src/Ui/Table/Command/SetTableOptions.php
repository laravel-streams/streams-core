<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetTableOptions.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetTableOptions implements SelfHandling
{
    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetTableOptions instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Resolver  $resolver
     * @param Evaluator $evaluator
     */
    public function handle(Resolver $resolver, Evaluator $evaluator)
    {
        $evaluator->evaluate(
            $resolver->resolve($this->builder->getOptions(), ['builder' => $this->builder]),
            ['builder' => $this->builder]
        );

        foreach ($this->builder->getOptions() as $key => $value) {
            $this->builder->setTableOption($key, $value);
        }
    }
}
