<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionBuilder;

/**
 * Class BuildActionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener\Command
 */
class BuildActionsCommandHandler
{

    /**
     * The action builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionBuilder
     */
    protected $builder;

    /**
     * Create a new BuildActionsCommandHandler instance.
     *
     * @param ActionBuilder $builder
     */
    public function __construct(ActionBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build actions and load them to the table.
     *
     * @param BuildActionsCommand $command
     */
    public function handle(BuildActionsCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
