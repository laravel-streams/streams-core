<?php namespace Streams\Core\Ui;

use Streams\Core\Ui\Component\Form;
use Streams\Core\Ui\Component\FormTab;
use Streams\Core\Ui\Component\FormRow;
use Streams\Core\Ui\Component\FormField;
use Streams\Core\Ui\Component\FormColumn;
use Streams\Core\Ui\Component\FormSection;
use Streams\Core\Ui\Component\FormTabContent;
use Streams\Core\Ui\Component\FormTabHeading;
use Streams\Core\Ui\Component\FormTabbedSection;
use Streams\Core\Ui\Collection\FormColumnCollection;
use Streams\Core\Ui\Collection\FormFieldCollection;
use Streams\Core\Ui\Collection\FormRowCollection;
use Streams\Core\Ui\Collection\FormTabCollection;
use Streams\Core\Ui\Repository\EntryRepository;
use Streams\Core\Ui\Handler\FormHandler;

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
     * @var null
     */
    protected $sections = null;

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
     * The form view to use.
     *
     * @var string
     */
    protected $formView = 'streams/form';

    /**
     * The wrapper view to use.
     *
     * @var string
     */
    protected $wrapperView = 'html/blank';

    /**
     * Create a new FormUi instance.
     *
     * @param null $slug
     * @param null $namespace
     */
    public function __construct($model = null)
    {
        $this->form    = $this->newForm();
        $this->handler = $this->newFormHandler();

        if ($model) {
            return $this->make($model);
        }

        return $this;
    }

    /**
     * Do the work for rendering a form..
     *
     * @return $this
     */
    protected function trigger()
    {
        if ($_POST) {
            $this->entry = $this->handler->save();
        }

        $this->output = $this->form->render();

        return $this;
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
     * Set the sections of the form.
     *
     * @param $sections
     * @return $this
     */
    public function setSections($sections)
    {
        foreach ($sections as $section) {
            $this->addSection($section);
        }

        return $this;
    }

    /**
     * Add a section to the form.
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
     * Get the skips array.
     *
     * @return array
     */
    public function getSkips()
    {
        return $this->skips;
    }

    /**
     * Set the skipped fields.
     *
     * @param $skipped
     * @return $this
     */
    public function setSkips($skips)
    {
        foreach ($skips as $skip) {
            $this->addSkip($skip);
        }

        return $this;
    }

    /**
     * Add a field to skip.
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
     * Set the actions for the form.
     *
     * @param $actions
     * @return $this
     */
    public function setActions($actions)
    {
        foreach ($actions as $action) {
            $this->addAction($action);
        }

        return $this;
    }

    /**
     * Add a action to the form.
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
     * Get the entry object.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
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
     * Return a new Form instance.
     *
     * @return Form
     */
    public function newForm()
    {
        return new Form($this);
    }

    /**
     * Return a new FormLayout instance.
     *
     * @return FormLayout
     */
    public function newFormLayout()
    {
        return new FormLayout($this);
    }

    /**
     * Return a new FormSection instance.
     *
     * @return FormSection
     */
    public function newFormSection()
    {
        return new FormSection($this);
    }

    /**
     * Return a new FormTabbedSection instance.
     *
     * @return FormTabbedSection
     */
    public function newFormTabbedSection()
    {
        return new FormTabbedSection($this);
    }

    /**
     * Return a new FormTab instance.
     *
     * @return FormTab
     */
    public function newFormTab()
    {
        return new FormTab($this);
    }

    /**
     * Return a new form tab heading instance.
     *
     * @return FormTabHeading
     */
    public function newFormTabHeading()
    {
        return new FormTabHeading($this);
    }

    /**
     * Return a new form tab content instance.
     *
     * @return FormTabContent
     */
    public function newFormTabContent()
    {
        return new FormTabContent($this);
    }

    /**
     * Return a new FormRow instance.
     *
     * @return FormRow
     */
    public function newFormRow()
    {
        return new FormRow($this);
    }

    /**
     * Return a new FormColumn instance.
     *
     * @return FormColumn
     */
    public function newFormColumn()
    {
        return new FormColumn($this);
    }

    /**
     * Return a new form field instance.
     *
     * @return FormField
     */
    public function newFormField()
    {
        return new FormField($this);
    }

    /**
     * Return a new entry repository instance.
     *
     * @return EntryRepository
     */
    public function newEntryRepository()
    {
        return new EntryRepository($this);
    }

    /**
     * Return a new form tab collection instance.
     *
     * @param $items
     * @return FormTabCollection
     */
    public function newFormTabCollection($items)
    {
        return new FormTabCollection($items);
    }

    /**
     * Return a new form row collection instance.
     *
     * @param $items
     * @return FormRowCollection
     */
    public function newFormRowCollection($items)
    {
        return new FormRowCollection($items);
    }

    /**
     * Return a new form column collection instance.
     *
     * @param $items
     * @return FormColumnCollection
     */
    public function newFormColumnCollection($items)
    {
        return new FormColumnCollection($items);
    }

    /**
     * Return a new form field collection instance.
     *
     * @param $items
     * @return FormFieldCollection
     */
    public function newFormFieldCollection($items)
    {
        return new FormFieldCollection($items);
    }

    /**
     * Return a new form handler instance.
     *
     * @return FormHandler
     */
    protected function newFormHandler()
    {
        return new FormHandler($this);
    }
}
