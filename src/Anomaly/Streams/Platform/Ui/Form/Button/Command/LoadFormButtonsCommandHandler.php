<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;

class LoadFormButtonsCommandHandler
{

    protected $factory;

    function __construct(ButtonFactory $factory)
    {
        $this->factory = $factory;
    }

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
 