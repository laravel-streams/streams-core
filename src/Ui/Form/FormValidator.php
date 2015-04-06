<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

/**
 * Class FormValidator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormValidator
{

    use DispatchesCommands;

    /**
     * The form rules compiler.
     *
     * @var FormRules
     */
    protected $rules;

    /**
     * The extender utility.
     *
     * @var FormExtender
     */
    protected $extender;

    /**
     * The messages utility.
     *
     * @var FormMessages
     */
    protected $messages;

    /**
     * The HTTP request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new FormValidator instance.
     *
     * @param Request      $request
     * @param FormRules    $rules
     * @param FormExtender $extender
     * @param FormMessages $messages
     */
    public function __construct(
        Request $request,
        FormRules $rules,
        FormExtender $extender,
        FormMessages $messages
    ) {
        $this->rules    = $rules;
        $this->request  = $request;
        $this->extender = $extender;
        $this->messages = $messages;
    }

    /**
     * Validate a form's input.
     *
     * @param FormBuilder $builder
     */
    public function validate(FormBuilder $builder)
    {
        $factory = app('validator');

        $form = $builder->getForm();

        $this->extender->extend($factory, $form);

        $input    = $this->request->all();
        $messages = $this->messages->get($form);
        $rules    = $this->rules->compile($form);

        $validator = $factory->make($input, $rules, $messages);

        $this->setResponse($validator, $form);
    }

    /**
     * Set the response based on validation.
     *
     * @param Validator $validator
     * @param Form      $form
     */
    protected function setResponse(Validator $validator, Form $form)
    {
        if (!$validator->passes()) {
            $form->setErrors($validator->getMessageBag());
        }
    }
}
