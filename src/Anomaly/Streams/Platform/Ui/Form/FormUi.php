<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationPassedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSubmittedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationPassedEvent;
use Anomaly\Streams\Platform\Ui\Ui;

/**
 * Class FormUi
 *
 * This class is responsible for rendering entry
 * forms and handling their primary features.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormUi extends Ui
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
     * Make the response.
     *
     * @return \Illuminate\View\View
     */
    public function make($entry = null)
    {
        $this->entry = $entry;

        return $this->fire('make');
    }

    /**
     * Trigger logic to build content.
     *
     * @return null|string
     */
    protected function trigger()
    {
        $this->fire('trigger');

        $form = $this->newFormService();

        $actions   = $form->actions();
        $sections  = $form->sections();
        $redirects = $form->redirects();

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

    protected function newFormService()
    {
        return new FormService($this);
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
 