<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class HandleFormCommandHandler
{

    public function handle(HandleFormCommand $command)
    {
        $builder = $command->getBuilder();

        $this->handleTableAction($builder);
    }

    protected function handleTableAction(FormBuilder $builder)
    {
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

            $form->setResponse(redirect(app('request')->fullUrl()));
        }
    }
}
 