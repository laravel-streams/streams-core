<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Message\Message;
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
     * The message bag.
     *
     * @var Message
     */
    protected $message;

    /**
     * The extender utility.
     *
     * @var FormExtender
     */
    protected $extender;

    /**
     * Create a new FormValidator instance.
     *
     * @param FormInput    $input
     * @param FormRules    $rules
     * @param Message      $message
     * @param FormExtender $extender
     */
    public function __construct(FormInput $input, FormRules $rules, Message $message, FormExtender $extender)
    {
        $this->input    = $input;
        $this->rules    = $rules;
        $this->message  = $message;
        $this->extender = $extender;
    }

    /**
     * Validate a form's input.
     *
     * @param Form $form
     */
    public function validate(Form $form)
    {
        $validator = app('validator');

        $rules = $this->rules->compile($form);
        $input = $this->input->get($form, config('app.locale'));

        $this->extender->extend($validator, $form->getFields());

        $validator = $validator->make($input, $rules);

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

            $this->message->error($validator->getMessageBag()->all());
        }
    }
}
