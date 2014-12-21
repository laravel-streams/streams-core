<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\Action\ActionBuilder;

/**
 * Class BuildFormActionsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Action\Command
 */
class BuildFormActionsCommandHandler
{

    /**
     * The form builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Action\ActionBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormActionsCommandHandler instance.
     *
     * @param ActionBuilder $builder
     */
    public function __construct(ActionBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build form actions.
     *
     * @param BuildFormActionsCommand $command
     */
    public function handle(BuildFormActionsCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
