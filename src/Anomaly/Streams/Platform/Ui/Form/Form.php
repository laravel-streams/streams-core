<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\MadeEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\MakingEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\SubmittedEvent;
use Anomaly\Streams\Platform\Ui\Table\Event\BootedEvent;
use Anomaly\Streams\Platform\Ui\Ui;
use Illuminate\Contracts\Support\MessageBag;

/**
 * Class Form
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class Form extends Ui
{

    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * Fields to skip entirely.
     *
     * @var array
     */
    protected $skips = [];

    /**
     * Fields to include. These are usually
     * custom fields sent to the form that
     * would otherwise get skipped because
     * they are not an "streams" field.
     *
     * @var array
     */
    protected $include = [];

    /**
     * Form sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Form redirects. After a form is
     * successfully submitted a redirect
     * will handle where to go from there.
     *
     * @var array
     */
    protected $redirects = [];

    /**
     * Form actions. These are action links
     * placed in the lower right corner of
     * forms as a convenient way to take action
     * on the entry you are editing.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * The view for the form.
     *
     * @var string
     */
    protected $view = 'ui/form/index';

    /**
     * A message bag of errors generated
     * from failed form submissions.
     *
     * @var null
     */
    protected $errors = null;

    /**
     * The success message displayed after
     * a successful form submission.
     *
     * @var string
     */
    protected $successMessage = 'message.entry_saved';

    /**
     * The authorization failure message
     * used when the user is not authorized
     * to submit the form.
     *
     * @var string
     */
    protected $authorizationFailedMessage = 'error.not_authorized';

    /**
     * The rules to apply to validation.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The submitted input payload
     * by locale ready for storage.
     *
     * @var array
     */
    protected $input = [];

    /**
     * The form builder object.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * The form utility object.
     *
     * @var FormUtility
     */
    protected $utility;

    /**
     * The form repository object.
     *
     * @var FormRepository
     */
    protected $repository;

    /**
     * Create a new Form instance.
     */
    function __construct()
    {
        $this->builder    = $this->newBuilder();
        $this->utility    = $this->newUtility();
        $this->repository = $this->newRepository();

        parent::__construct();

        $this->dispatch(new BootedEvent($this));
    }

    /**
     * Make the form response.
     *
     * @param null $entry
     * @return mixed|null
     */
    public function make($entry = null)
    {
        $this->dispatch(new MakingEvent($this));

        if ($entry and !$this->entry) {

            $this->entry = $entry;
        }

        $this->entry = $this->repository->get();

        if (app('request')->isMethod('post')) {

            $this->dispatch(new SubmittedEvent($this));
        }

        if (!$this->response) {

            $this->setResponse(parent::make());
        }

        $this->dispatch(new MadeEvent($this));

        return $this->response;
    }

    /**
     * Render the form response.
     *
     * @param null $entry
     * @return mixed|null
     */
    public function render($entry = null)
    {
        if (app('request')->isMethod('post')) {

            return $this->make($entry);
        } else {

            return $this->make($entry)->render();
        }
    }

    /**
     * Trigger the view response.
     *
     * @return \Illuminate\View\View
     */
    protected function trigger()
    {
        $actions   = $this->builder->actions();
        $sections  = $this->builder->sections();
        $redirects = $this->builder->redirects();
        $options   = $this->builder->options();

        $data = compact('actions', 'sections', 'redirects', 'options');

        return view($this->view, $data);
    }

    /**
     * Set the entry object.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }


    /**
     * Get the entry object.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the redirects configuration.
     *
     * @param array $redirects
     * @return $this
     */
    public function setRedirects(array $redirects)
    {
        $this->redirects = $redirects;

        return $this;
    }

    /**
     * Add a redirect configuration.
     *
     * @param $redirect
     * @return $this
     */
    public function addRedirect($redirect)
    {
        $this->redirects[] = $redirect;

        return $this;
    }

    /**
     * Get the redirects configuration.
     *
     * @return array
     */
    public function getRedirects()
    {
        return $this->redirects;
    }

    /**
     * Set the actions configuration.
     *
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Add an action configuration.
     *
     * @param $action
     * @return $this
     */
    public function addAction($action)
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Get the actions configuration.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set the sections configuration.
     *
     * @param array $sections
     * @return $this
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * Add a section configuration.
     *
     * @param $section
     * @return $this
     */
    public function addSection($section)
    {
        $this->sections[] = $section;

        return $this;
    }

    /**
     * Get the sections configuration.
     *
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set fields to skip.
     *
     * @param array $fields
     * @return $this
     */
    public function setSkips(array $fields)
    {
        $this->skips = $fields;

        return $this;
    }

    /**
     * Add a field to skip.
     *
     * @param $field
     * @return $this
     */
    public function addSkip($field)
    {
        $this->skips[] = $field;

        return $this;
    }

    /**
     * Get the fields to skip.
     *
     * @return array
     */
    public function getSkips()
    {
        return $this->skips;
    }

    /**
     * Set included fields.
     *
     * @param array $fields
     * return $this
     */
    public function setInclude($fields)
    {
        $this->include = $fields;

        return $this;
    }

    /**
     * Add an included field.
     *
     * @param $field
     * @return $this
     */
    public function addInclude($field)
    {
        $this->include[] = $field;

        return $this;
    }

    /**
     * Get included fields.
     *
     * @return array
     */
    public function getInclude()
    {
        return $this->include;
    }

    /**
     * Set the view.
     *
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Set the error messages.
     *
     * @param MessageBag $errors
     * @return $this
     */
    public function setErrors(MessageBag $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Get the error messages.
     *
     * @return null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the success message.
     *
     * @param $message
     * @return $this
     */
    public function setSuccessMessage($message)
    {
        $this->successMessage = $message;

        return $this;
    }

    /**
     * Get the success message.
     *
     * @return string
     */
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }

    /**
     * Set the authorization failed message.
     *
     * @param $message
     * @return $this
     */
    public function setAuthorizationFailedMessage($message)
    {
        $this->authorizationFailedMessage = $message;

        return $this;
    }

    /**
     * Get the authorization failed message.
     *
     * @return string
     */
    public function getAuthorizationFailedMessage()
    {
        return $this->authorizationFailedMessage;
    }


    /**
     * Set the rules for the form. This is
     * done during form submission automatically.
     *
     * @param array $rules
     * return $this
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Add a rule to a field.
     *
     * @param $field
     * @param $rule
     */
    public function addRule($field, $rule)
    {
        if (!isset($this->rules[$field])) {

            $this->rules[$field] = [];
        }

        $this->rules[$field] = $rule;
    }

    /**
     * Get the rules for the form.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Add a value to the data payload.
     *
     * @param $group
     * @param $field
     * @param $value
     * @return $this
     */
    public function addInput($group, $field, $value)
    {
        if (!isset($this->input[$group])) {

            $this->input[$group] = [];
        }

        $this->input[$group][$field] = $value;

        return $this;
    }

    /**
     * Get the data payload.
     *
     * @param null $group
     * @return array
     */
    public function getInput($group = null)
    {
        if ($group) {

            return $this->input[$group];
        }

        return $this->input;
    }

    /**
     * Return the stream from the model if applicable.
     *
     * @return \Anomaly\Streams\Platform\Stream\Contract\StreamInterface|null
     */
    public function getStream()
    {
        if ($this->model instanceof EntryInterface) {

            return $this->model->getStream();
        }

        return null;
    }

    /**
     * Return a new FormBuilder object.
     *
     * @return mixed
     */
    protected function newBuilder()
    {
        if (!$builder = $this->transform(__FUNCTION__)) {

            $builder = 'Anomaly\Streams\Platform\Ui\Form\FormBuilder';
        }

        return app()->make($builder, ['form' => $this]);
    }

    /**
     * Return a new FormRepository object.
     *
     * @return mixed
     */
    protected function newRepository()
    {
        if (!$builder = $this->transform(__FUNCTION__)) {

            $builder = 'Anomaly\Streams\Platform\Ui\Form\FormRepository';
        }

        return app()->make($builder, [$this]);
    }

    /**
     * Return the class path to the corresponding validator object.
     *
     * @return null|string
     */
    public function toValidator()
    {
        if (!$validator = $this->transform(__FUNCTION__)) {

            $validator = 'Anomaly\Streams\Platform\Ui\Form\FormValidator';
        }

        return $validator;
    }

    /**
     * Return the class path to the corresponding authority object.
     *
     * @return null|string
     */
    public function toAuthority()
    {
        if (!$authority = $this->transform(__FUNCTION__)) {

            $authority = 'Anomaly\Streams\Platform\Ui\Form\FormAuthority';
        }

        return $authority;
    }
}
 