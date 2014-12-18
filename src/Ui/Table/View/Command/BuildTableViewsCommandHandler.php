<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\View\ViewBuilder;

/**
 * Class BuildTableViewsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View\Command
 */
class BuildTableViewsCommandHandler
{

    /**
     * The view builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\View\ViewBuilder
     */
    protected $builder;

    /**
     * Create a new TableLoadListener instance.
     *
     * @param ViewBuilder $builder
     */
    public function __construct(ViewBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build views and load them to the table.
     *
     * @param BuildTableViewsCommand $command
     */
    public function handle(BuildTableViewsCommand $command)
    {
        $this->builder->load($command->getBuilder());
    }
}
