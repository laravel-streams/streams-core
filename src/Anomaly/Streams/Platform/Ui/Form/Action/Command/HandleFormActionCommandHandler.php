<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

class HandleFormActionCommandHandler
{

    public function handle(HandleFormActionCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $actions = $form->getActions();

        if ($form->getResponse() === null and $action = $actions->active()) {

            $handler = $action->getHandler();

            if (is_string($handler) or $handler instanceof \Closure) {

                app()->call($handler, compact('table', 'ids'));
            }

            if ($handler === null) {

                $action->handle($form);
            }

            app('streams.messages')->flash();

            if ($form->getResponse() === null) {

                $form->setResponse(action(app('request')->fullUrl()));
            }
        }
    }
}
 