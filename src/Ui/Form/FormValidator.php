<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Event\FormIsValidating;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasValidated;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailed;
use Illuminate\Events\Dispatcher;
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

    /**
     * The form rules compiler.
     *
     * @var FormRules
     */
    protected $rules;

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
     * @param Dispatcher   $events
     * @param FormExtender $extender
     * @param FormMessages $messages
     */
    public function __construct(
        Request $request,
        FormRules $rules,
        Dispatcher $events,
        FormExtender $extender,
        FormMessages $messages
    ) {
        $this->rules    = $rules;
        $this->events   = $events;
        $this->request  = $request;
        $this->extender = $extender;
        $this->messages = $messages;
    }

    /**
     * Validate a form's input.
     *
     * @param Form $form
     */
    public function validate(Form $form)
    {
        $factory = app('validator');

        $form->fire('validating');
        $this->events->fire(new FormIsValidating($form));

        $this->extender->extend($factory, $form);

        $input    = $this->request->all();
        $messages = $this->messages->get($form);
        $rules    = $this->rules->compile($form);

        $validator = $factory->make($input, $rules, $messages);

        $this->setResponse($validator, $form);

        $form->fire('validated');
        $this->events->fire(new FormWasValidated($form));
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

            $this->events->fire(new ValidationFailed($form));
        }
    }
}
