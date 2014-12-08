<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

class HandleFormValidationCommandHandler
{

    public function handle(HandleFormValidationCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $validator = app('validator')->make($form->pullInput(config('app.locale')), $form->getRules());

        if ($validator->fails()) {

            app('streams.messages')->add('error', $validator->messages()->all());

            $form->setResponse(false);
        }
    }
}
 