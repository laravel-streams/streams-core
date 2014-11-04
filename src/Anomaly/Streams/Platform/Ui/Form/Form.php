<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormBuilderInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSubmittedEvent;
use Anomaly\Streams\Platform\Ui\Ui;

/**
 * Class Form
 *
 * This class is responsible for rendering entry
 * forms and handling their primary features.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class Form extends Ui
{

    protected $entry = null;

    protected $skips = [];

    protected $sections = [];

    protected $redirects = [];

    protected $actions = [];

    protected $view = 'html/form';

    protected $errors = [];

    protected $authorizationFailedMessage = 'error.not_authorized';

    /**
     * Get the response.
     *
     * @param null $entry
     * @return \Illuminate\View\View|mixed|null
     */
    public function make($entry = null)
    {
        if ($entry) {

            $this->entry = $entry;
        }

        return $this->fire('make');
    }

    public function render($entry = null)
    {
        return $this->make($entry)->render();
    }

    /**
     * Trigger the response.
     *
     * @return \Illuminate\View\View|null
     */
    protected function trigger()
    {
        $this->fire('trigger');

        $builder = $this->toBuilder();

        $actions   = $builder->actions();
        $sections  = $builder->sections();
        $redirects = $builder->redirects();

        $data = compact('actions', 'sections', 'redirects');

        return view($this->view, $data);
    }

    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    public function getEntry()
    {
        return $this->entry;
    }

    public function setRedirects(array $redirects)
    {
        $this->redirects = $redirects;

        return $this;
    }


    public function getRedirects()
    {
        return $this->redirects;
    }

    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function setSections(array $sections)
    {
        $this->sections = $sections;

        return $this;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function setSkips(array $skips)
    {
        $this->skips = $skips;

        return $this;
    }

    public function getSkips()
    {
        return $this->skips;
    }

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getAuthorizationFailedMessage()
    {
        return $this->authorizationFailedMessage;
    }

    protected function toBuilder()
    {
        if (!$builder = $this->transform(__METHOD__)) {

            $builder = 'Anomaly\Streams\Platform\Ui\Form\FormBuilder';
        }

        return app()->make($builder, [$this]);
    }

    protected function newRepository()
    {
        return new FormRepository($this, $this->model);
    }

    public function toValidator()
    {
        if (!$validator = $this->transform(__METHOD__)) {

            $validator = 'Anomaly\Streams\Platform\Ui\Form\FormUiValidator';
        }

        return $validator;
    }

    public function toAuthorizer()
    {
        if (!$authorizer = $this->transform(__METHOD__)) {

            $authorizer = 'Anomaly\Streams\Platform\Ui\Form\FormUiAuthorizer';
        }

        return $authorizer;
    }

    protected function onMake()
    {
        $this->entry = $this->newRepository()->get();

        if (app('request')->isMethod('post')) {

            $this->dispatch(new FormWasSubmittedEvent($this));
        } else {

            $this->setResponse(parent::make());
        }

        return $this->response;
    }
}
 