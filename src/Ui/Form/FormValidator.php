<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Message\Message;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldCollection;
use Illuminate\Validation\Factory;
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
     * Create a new FormValidator instance.
     *
     * @param FormInput $input
     * @param FormRules $rules
     */
    public function __construct(FormInput $input, FormRules $rules, Message $message)
    {
        $this->input   = $input;
        $this->rules   = $rules;
        $this->message = $message;
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

        $this->extendValidator($validator, $form->getFields());

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

    /**
     * Extend the validator with the fields.
     *
     * @param Factory         $factory
     * @param FieldCollection $fields
     */
    protected function extendValidator(Factory $factory, FieldCollection $fields)
    {
        foreach ($fields as $field) {
            if ($field instanceof FieldType && $validators = $field->getValidators()) {
                foreach ($validators as $rule => $validator) {
                    if ($handler = array_get($validator, 'handler')) {
                        $factory->extend($rule, $handler);
                    }
                }
            }
        }
    }
}
