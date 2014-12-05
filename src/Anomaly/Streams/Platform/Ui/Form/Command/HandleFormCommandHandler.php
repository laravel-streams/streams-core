<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class HandleFormCommandHandler
{

    public function handle(HandleFormCommand $command)
    {
        $builder = $command->getBuilder();

        $this->handleAuthorization($builder);
        $this->handleValidation($builder);
        $this->handleTableAction($builder);
    }

    protected function handleAuthorization(FormBuilder $builder)
    {
        // Authorize form.
    }

    protected function handleValidation(FormBuilder $builder)
    {
        // Validate form.
    }

    protected function handleTableAction(FormBuilder $builder)
    {
        $form      = $builder->getForm();
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

            $form->setResponse(action(app('request')->fullUrl()));
        }
    }
}
 