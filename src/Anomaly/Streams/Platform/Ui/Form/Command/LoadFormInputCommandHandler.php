<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

class LoadFormInputCommandHandler
{

    public function handle(LoadFormInputCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $stream  = $form->getStream();

        if (app('request')->isMethod('post') and $stream instanceof StreamInterface) {
            // Set the input
        }
    }
}
 