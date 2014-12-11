<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

class RunFormHandlerCommandHandler
{

    public function handle(RunFormHandlerCommand $command)
    {
        $builder = $command->getBuilder();
        $handler = $builder->getHandler();
        $form    = $builder->getForm();

        if ($form->getResponse() === null) {

            if (is_string($handler) || $handler instanceof \Closure) {

                app()->call($handler, compact('builder'));
            }
        }
    }
}
 