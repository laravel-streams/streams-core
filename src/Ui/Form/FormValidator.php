<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Command\RepopulateFields;
use Anomaly\Streams\Platform\Ui\Form\Command\SetErrorMessages;
use Illuminate\Foundation\Bus\DispatchesCommands;
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
     * The form input utility.
     *
     * @var FormInput
     */
    protected $input;

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
     * Create a new FormValidator instance.
     *
     * @param FormRules    $rules
     * @param FormInput    $input
     * @param FormExtender $extender
     * @param FormMessages $messages
     */
    public function __construct(
        FormRules $rules,
        FormInput $input,
        FormExtender $extender,
        FormMessages $messages
    ) {
        $this->rules    = $rules;
        $this->input    = $input;
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

        $this->extender->extend($factory, $builder);

        $input    = $this->input->all($builder);
        $messages = $this->messages->get($builder);
        $rules    = $this->rules->compile($builder);

        /* @var Validator $validator */
        $validator = $factory->make($input, $rules);

        $validator->setCustomMessages($messages);

        $this->setResponse($validator, $builder);
    }

    /**
     * Set the response based on validation.
     *
     * @param Validator   $validator
     * @param FormBuilder $builder
     */
    protected function setResponse(Validator $validator, FormBuilder $builder)
    {
        if (!$validator->passes()) {

            $builder
                ->setSave(false)
                ->setFormErrors($validator->getMessageBag());

            $this->dispatch(new SetErrorMessages($builder));
            $this->dispatch(new RepopulateFields($builder));
        }
    }
}
