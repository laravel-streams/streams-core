<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewBuilder;

/**
 * Class BuildViewsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\Command
 */
class BuildViewsCommandHandler
{

    /**
     * The view builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewBuilder
     */
    protected $builder;

    /**
     * Create a new BuildViewsCommandHandler instance.
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
     * @param BuildViewsCommand $command
     */
    public function handle(BuildViewsCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
