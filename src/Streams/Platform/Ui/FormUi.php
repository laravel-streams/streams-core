<?php namespace Streams\Platform\Ui;

use Streams\Platform\Ui\Component\Form;
use Streams\Platform\Ui\Support\Repository;
use Streams\Platform\Ui\Handler\ActionHandler;
use Streams\Platform\Ui\Builder\FormSectionBuilder;
use Streams\Platform\Ui\Collection\FormActionCollection;

class FormUi extends UiAbstract
{
    /**
     * The entry model.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * Sections of form structure.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * Fields to skip.
     *
     * @var array
     */
    protected $skips = [];

    /**
     * Form submittable actions.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * The UI status.
     *
     * @var null
     */
    protected $status = null;

    /**
     * The form view.
     *
     * @var string
     */
    protected $formView = 'html/form';

    /**
     * The wrapper view.
     *
     * @var string
     */
    protected $wrapper = 'html/blank';

    /**
     * The repository object.
     *
     * @var Support\Repository
     */
    protected $repository;

    /**
     * The form object.
     *
     * @var Component\Form
     */
    protected $form;

    /**
     * Create a new FormUi instance.
     *
     * @param null $model
     */
    public function __construct($model = null)
    {
        if ($model) {
            $this->model = $model;
        }

        $this->form       = $this->newForm($this);
        $this->repository = $this->newRepository($this);

        return $this;
    }

    /**
     * Do the work for rendering a form..
     *
     * @return $this
     */
    protected function trigger()
    {
        if (is_numeric($this->entry)) {
            $this->entry = $this->repository->find($this->entry);
        } elseif ($this->entry === null) {
            $this->entry = $this->repository->newEntry();
        }

        if ($_POST) {
            $this->entry = $this->repository->save();
        }

        $this->output = \View::make($this->formView, $this->form->data());

        return $this;
    }

    /**
     * Return a collection of actions.
     *
     * @return FormActionCollection
     */
    public function actions()
    {
        return new FormActionCollection($this->actions);
    }

    /**
     * Return the sections array.
     *
     * @return null
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set the sections.
     *
     * @param $sections
     * @return $this
     */
    public function setSections($sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * Add a section.
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
     * Get the skips.
     *
     * @return array
     */
    public function getSkips()
    {
        return $this->skips;
    }

    /**
     * Set the skips.
     *
     * @param $skips
     * @return $this
     */
    public function setSkips($skips)
    {
        $this->skips = $skips;

        return $this;
    }

    /**
     * Add a skip.
     *
     * @param $skip
     * @return $this
     */
    public function addSkip($skip)
    {
        $this->skips[] = $skip;

        return $this;
    }

    /**
     * Get the actions.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set the actions.
     *
     * @param $actions
     * @return $this
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Add a action.
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
     * Get the entry.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry.
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
     * Get the status.
     *
     * @return null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the status.
     *
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Return a new Form instance.
     *
     * @param $ui
     * @return Form
     */
    public function newForm($ui)
    {
        return new Form($ui);
    }

    /**
     * Return a new FormSectionBuilder instance.
     *
     * @param $ui
     * @return FormSectionBuilder
     */
    public function newSectionBuilder($ui)
    {
        return new FormSectionBuilder($ui);
    }
}
