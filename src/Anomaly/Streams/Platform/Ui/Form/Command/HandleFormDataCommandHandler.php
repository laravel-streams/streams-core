<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

class HandleFormDataCommandHandler
{

    public function handle(HandleFormDataCommand $command)
    {
        $form = $command->getForm();

        $repository = $form->getRepository();

        $repository->store();
    }
}
 