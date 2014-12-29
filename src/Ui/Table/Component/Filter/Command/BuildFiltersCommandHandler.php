<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;

/**
 * Class BuildFiltersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\Command
 */
class BuildFiltersCommandHandler
{

    /**
     * The filter builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFiltersCommandHandler instance.
     *
     * @param FilterBuilder $builder
     */
    public function __construct(FilterBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build views and load them to the table.
     *
     * @param BuildFiltersCommand $command
     */
    public function handle(BuildFiltersCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
