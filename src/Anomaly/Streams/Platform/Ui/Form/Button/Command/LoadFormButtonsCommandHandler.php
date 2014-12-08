<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

class LoadFormButtonsCommandHandler
{

    public function handle(LoadFormButtonsCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $buttons = $form->getButtons();

        foreach ($builder->getButtons() as $parameters) {

            $button = $this->execute(
                'Anomaly\Streams\Platform\Ui\Button\Command\MakeButtonCommand',
                compact('parameters')
            );

            $button->setSize('sm');

            $buttons->push($button);
        }
    }
}
 