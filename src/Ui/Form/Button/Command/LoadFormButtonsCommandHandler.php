<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

use Anomaly\Streams\Platform\Ui\Table\Button\ButtonFactory;

/**
 * Class LoadFormButtonsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Button\Command
 */
class LoadFormButtonsCommandHandler
{

    /**
     * The form builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Button\ButtonFactory
     */
    protected $factory;

    /**
     * Create a new LoadFormButtonsCommandHandler instance.
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
     * @param LoadFormButtonsCommand $command
     */
    public function handle(LoadFormButtonsCommand $command)
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
