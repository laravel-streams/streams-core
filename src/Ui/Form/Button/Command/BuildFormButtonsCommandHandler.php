<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

use Anomaly\Streams\Platform\Ui\Button\ButtonBuilder;

/**
 * Class BuildFormButtonsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Button\Command
 */
class BuildFormButtonsCommandHandler
{

    /**
     * The button builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Button\ButtonBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormButtonsCommandHandler instance.
     *
     * @param ButtonBuilder $builder
     */
    public function __construct(ButtonBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param BuildFormButtonsCommand $command
     */
    public function handle(BuildFormButtonsCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->builder->load($builder->getButtons(), $form->getButtons());
    }
}
