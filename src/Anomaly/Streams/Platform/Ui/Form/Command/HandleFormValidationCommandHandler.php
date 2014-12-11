<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

class HandleFormValidationCommandHandler
{
    public function handle(HandleFormValidationCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $input = $form->pullInput(config('app.locale'), []) + $form->pullInput('include', []);

        $validator = app('validator')->make($input, $form->getRules());

        if ($validator->fails()) {
            app('session')->flash('error', $validator->messages()->all());

            $form->setResponse(false);
        }
    }
}
