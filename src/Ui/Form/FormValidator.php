<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailed;
use Illuminate\Events\Dispatcher;
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

    /**
     * The form input utility.
     *
     * @var FormInput
     */
    protected $input;

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
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * The messages utility.
     *
     * @var FormMessages
     */
    protected $messages;

    /**
     * Create a new FormValidator instance.
     *
     * @param FormInput    $input
     * @param FormRules    $rules
     * @param Dispatcher   $dispatcher
     * @param FormExtender $extender
     * @param FormMessages $messages
     */
    public function __construct(
        FormInput $input,
        FormRules $rules,
        Dispatcher $dispatcher,
        FormExtender $extender,
        FormMessages $messages
    ) {
        $this->input      = $input;
        $this->rules      = $rules;
        $this->extender   = $extender;
        $this->messages   = $messages;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Validate a form's input.
     *
     * @param Form $form
     */
    public function validate(Form $form)
    {
        $validator = app('validator');

        $messages = $this->messages->get($form);
        $rules    = $this->rules->compile($form);
        $input    = $this->input->get($form, config('app.locale'));

        $this->extender->extend($validator, $form);

        $validator = $validator->make($input, $rules, $messages);

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

            $this->dispatcher->fire(new ValidationFailed($form));
        }
    }
}
