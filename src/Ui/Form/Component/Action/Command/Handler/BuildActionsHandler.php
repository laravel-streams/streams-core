<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions;

/**
 * Class BuildActionsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Listener\Command
 */
class BuildActionsHandler
{

    /**
     * The action builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionBuilder
     */
    protected $builder;

    /**
     * Create a new BuildActionsHandler instance.
     *
     * @param ActionBuilder $builder
     */
    public function __construct(ActionBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build actions and load them to the form.
     *
     * @param BuildActions $command
     */
    public function handle(BuildActions $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
