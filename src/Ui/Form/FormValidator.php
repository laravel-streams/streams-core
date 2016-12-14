<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Command\RepopulateFields;
use Anomaly\Streams\Platform\Ui\Form\Command\SetErrorMessages;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasValidated;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

/**
 * Class FormValidator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormValidator
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

        $builder->setFormErrors(new MessageBag());

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

            $builder->setSave(false);

            $bag = $validator->getMessageBag();

            foreach ($bag->getMessages() as $field => $messages) {
                foreach ($messages as $message) {
                    $builder->addFormError($field, $message);
                }
            }

            $this->dispatch(new SetErrorMessages($builder));
        }

        $this->dispatch(new RepopulateFields($builder));
    }
}
