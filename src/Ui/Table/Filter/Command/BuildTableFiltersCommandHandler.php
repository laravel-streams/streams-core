<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\FilterBuilder;

/**
 * Class BuildTableFiltersCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter\Command
 */
class BuildTableFiltersCommandHandler
{

    /**
     * The filter builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Filter\FilterBuilder
     */
    protected $builder;

    /**
     * Create a new TableLoadListener instance.
     *
     * @param FilterBuilder $builder
     */
    public function __construct(FilterBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build filters and load them to the table.
     *
     * @param BuildTableFiltersCommand $command
     */
    public function handle(BuildTableFiltersCommand $command)
    {
        $this->builder->load($command->getBuilder());
    }
}
