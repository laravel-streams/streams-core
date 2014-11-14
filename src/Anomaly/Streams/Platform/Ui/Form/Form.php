<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSubmittedEvent;
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
     * The submitted data payload
     * by locale ready for storage.
     *
     * @var array
     */
    protected $data = [];

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
    }

    /**
     * Make the form response.
     *
     * @param null $entry
     * @return mixed|null
     */
    public function make($entry = null)
    {
        if ($entry) {

            $this->entry = $entry;
        }

        return $this->fire('make');
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
        $this->fire('trigger');

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
    public function addData($group, $field, $value)
    {
        if (!isset($this->data[$group])) {

            $this->data[$group] = [];
        }

        $this->data[$group][$field] = $value;

        return $this;
    }

    /**
     * Get the data payload.
     *
     * @param null $group
     * @return array
     */
    public function getData($group = null)
    {
        if ($group) {

            return $this->data[$group];
        }

        return $this->data;
    }

    /**
     * Get the form utility object.
     *
     * @return mixed
     */
    public function getUtility()
    {
        return $this->utility;
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
     * Return a new FormUtility object.
     *
     * @return mixed
     */
    protected function newUtility()
    {
        if (!$utility = $this->transform(__FUNCTION__)) {

            $utility = 'Anomaly\Streams\Platform\Ui\Form\FormUtility';
        }

        return app()->make($utility, ['form' => $this]);
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

        return app()->make($builder, ['form' => $this]);
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
     * Return the class path to the corresponding authorizer object.
     *
     * @return null|string
     */
    public function toAuthorizer()
    {
        if (!$authorizer = $this->transform(__FUNCTION__)) {

            $authorizer = 'Anomaly\Streams\Platform\Ui\Form\FormAuthorizer';
        }

        return $authorizer;
    }

    /**
     * Fire when making the form response.
     *
     * @return mixed
     */
    protected function onMake()
    {
        $this->entry = $this->repository->get();

        if (app('request')->isMethod('post')) {

            $this->dispatch(new FormWasSubmittedEvent($this));
        }

        if (!$this->response) {

            $this->setResponse(parent::make());
        }

        return $this->response;
    }

    /**
     * Fire just before validating.
     *
     * @param array $data
     */
    protected function onValidating(array $data)
    {
        return $data;
    }

    /**
     * Fire after authorized and
     * validated submission.
     */
    protected function onSubmit()
    {
        $this->repository->store();
    }
}
 