<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSubmittedEvent;
use Anomaly\Streams\Platform\Ui\Ui;

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

    protected $builder;

    protected $utility;

    protected $repository;

    function __construct()
    {
        $this->builder    = $this->newBuilder();
        $this->utility    = $this->newUtility();
        $this->repository = $this->newRepository();

        parent::__construct();
    }


    public function make($entry = null)
    {
        if ($entry) {

            $this->entry = $entry;
        }

        return $this->fire('make');
    }

    public function render($entry = null)
    {
        return $this->make($entry);
    }

    protected function trigger()
    {
        $this->fire('trigger');

        $actions   = $this->builder->actions();
        $sections  = $this->builder->sections();
        $redirects = $this->builder->redirects();

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

    public function getUtility()
    {
        return $this->utility;
    }

    protected function newBuilder()
    {
        if (!$builder = $this->transform(__METHOD__)) {

            $builder = 'Anomaly\Streams\Platform\Ui\Form\FormBuilder';
        }

        return app()->make($builder, ['form' => $this]);
    }

    protected function newUtility()
    {
        if (!$utility = $this->transform(__METHOD__)) {

            $utility = 'Anomaly\Streams\Platform\Ui\Form\FormUtility';
        }

        return app()->make($utility, ['form' => $this]);
    }

    protected function newRepository()
    {
        if (!$builder = $this->transform(__METHOD__)) {

            $builder = 'Anomaly\Streams\Platform\Ui\Form\FormRepository';
        }

        return app()->make($builder, ['form' => $this]);
    }

    public function toValidator()
    {
        if (!$validator = $this->transform(__METHOD__)) {

            $validator = 'Anomaly\Streams\Platform\Ui\Form\FormValidator';
        }

        return $validator;
    }

    public function toAuthorizer()
    {
        if (!$authorizer = $this->transform(__METHOD__)) {

            $authorizer = 'Anomaly\Streams\Platform\Ui\Form\FormAuthorizer';
        }

        return $authorizer;
    }

    protected function onMake()
    {
        $this->entry = $this->repository->get();

        if (app('request')->isMethod('post')) {

            $this->dispatch(new FormWasSubmittedEvent($this));
        } else {

            $this->setResponse(parent::make());
        }

        return $this->response;
    }
}
 