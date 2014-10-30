<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormSubmissionCommand;
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

    /**
     * Make the response.
     *
     * @return \Illuminate\View\View
     */
    public function make($entry = null)
    {
        $this->entry = $entry;

        if ($response = $this->fire('make')) {

            return $response;
        }

        return parent::make();
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

    protected function newFormService()
    {
        return new FormService($this);
    }

    protected function newRepository()
    {
        return new FormRepository($this, $this->model);
    }

    protected function onMake()
    {
        $this->entry = $this->newRepository()->get();

        if (app('request')->isMethod('post')) {

            return $this->execute(new HandleFormSubmissionCommand($this));
        }
    }
}
 