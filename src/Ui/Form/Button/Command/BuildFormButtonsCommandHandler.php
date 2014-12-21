<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

use Anomaly\Streams\Platform\Ui\Table\Button\ButtonFactory;

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
     * The form builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Button\ButtonFactory
     */
    protected $factory;

    /**
     * Create a new BuildFormButtonsCommandHandler instance.
     *
     * @param ButtonFactory $factory
     */
    public function __construct(ButtonFactory $factory)
    {
        $this->factory = $factory;
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
        $buttons = $form->getButtons();

        foreach ($builder->getButtons() as $parameters) {
            $button = $this->factory->make($parameters);

            $buttons->push($button);
        }
    }
}
