<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Command\FlashFieldValues;
use Anomaly\Streams\Platform\Ui\Form\Command\RepopulateFields;
use Anomaly\Streams\Platform\Ui\Form\Command\SetErrorMessages;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasValidated;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Validation\Validator;

/**
 * Class FormValidator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormValidator implements SelfHandling
{

    use DispatchesJobs;

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
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

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
     * The attributes builder.
     *
     * @var FormAttributes
     */
    protected $attributes;

    /**
     * Create a new FormValidator instance.
     *
     * @param FormRules      $rules
     * @param FormInput      $input
     * @param Dispatcher     $events
     * @param FormExtender   $extender
     * @param FormMessages   $messages
     * @param FormAttributes $attributes
     */
    public function __construct(
        FormRules $rules,
        FormInput $input,
        Dispatcher $events,
        FormExtender $extender,
        FormMessages $messages,
        FormAttributes $attributes
    ) {
        $this->rules      = $rules;
        $this->input      = $input;
        $this->events     = $events;
        $this->extender   = $extender;
        $this->messages   = $messages;
        $this->attributes = $attributes;
    }

    /**
     * Validate a form's input.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $factory = app('validator');

        $this->extender->extend($factory, $builder);

        $input      = $this->input->all($builder);
        $messages   = $this->messages->make($builder);
        $attributes = $this->attributes->make($builder);
        $rules      = $this->rules->compile($builder);

        /* @var Validator $validator */
        $validator = $factory->make($input, $rules);

        $validator->setCustomMessages($messages);
        $validator->setAttributeNames($attributes);

        $this->setResponse($validator, $builder);

        $this->events->fire(new FormWasValidated($builder));
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
            $this->dispatch(new FlashFieldValues($builder));
        }

        $this->dispatch(new RepopulateFields($builder));
    }
}
