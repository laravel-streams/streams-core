<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Validation\Validator;

class HandleFormValidationCommandHandler
{

    protected $validator;

    function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(HandleFormValidationCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();

        $this->validator->setRules($form->getRules());
        $this->validator->setData($form->pullInput(config('app.locale')));

        if ($this->validator->fails()) {

            app('streams.messages')->add('error', $this->validator->messages()->all())->flash();

            $form->setResponse(action(app('request')->fullUrl()));
        }
    }
}
 