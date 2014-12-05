<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class HandleFormCommandHandler
{

    public function handle(HandleFormCommand $command)
    {
        $builder = $command->getBuilder();

        $this->handleAuthorization($builder);
        $this->handleValidation($builder);
        $this->handleTableRedirect($builder);
    }

    protected function handleAuthorization(FormBuilder $builder)
    {
        // Authorize form.
    }

    protected function handleValidation(FormBuilder $builder)
    {
        // Validate form.
    }

    protected function handleTableRedirect(FormBuilder $builder)
    {
        $form      = $builder->getForm();
        $redirects = $form->getRedirects();

        if ($form->getResponse() === null and $redirect = $redirects->active()) {

            $handler = $redirect->getHandler();

            if (is_string($handler) or $handler instanceof \Closure) {

                app()->call($handler, compact('table', 'ids'));
            }

            if ($handler === null) {

                $redirect->handle($form);
            }

            app('streams.messages')->flash();

            $form->setResponse(redirect(app('request')->fullUrl()));
        }
    }
}
 