<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Validation\Validator;

class HandleFormCommandHandler
{

    protected $validator;

    function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(HandleFormCommand $command)
    {
        $builder = $command->getBuilder();

        $this->handleAuthorization($builder);
        $this->handleValidation($builder);
        $this->handleTableAction($builder);
    }

    protected function handleAuthorization(FormBuilder $builder)
    {
        // True for now - no access built just yet.
    }

    protected function handleValidation(FormBuilder $builder)
    {
        $form = $builder->getForm();

        $this->validator->setRules($form->getRules());
        $this->validator->setData($form->pullInput(config('app.locale')));

        if ($this->validator->fails()) {

            app('streams.messages')->add('error', $this->validator->messages()->all())->flash();

            $form->setResponse(action(app('request')->fullUrl()));
        }
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

            if ($form->getResponse() === null) {

                $form->setResponse(action(app('request')->fullUrl()));
            }
        }
    }
}
 