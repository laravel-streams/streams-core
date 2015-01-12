<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildForm;
use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormPost;
use Anomaly\Streams\Platform\Ui\Form\Command\LoadForm;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class FormBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form
 */
class FormBuilder
{

    use DispatchesCommands;

    /**
     * The form model.
     *
     * @var null
     */
    protected $model = null;

    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * The fields config.
     *
     * @var array
     */
    protected $fields = ['*'];

    /**
     * Fields to skip.
     *
     * @var array
     */
    protected $skips = [];

    /**
     * The actions config.
     *
     * @var array
     */
    protected $actions = ['save'];

    /**
     * The buttons config.
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * The form object.
     *
     * @var Form
     */
    protected $form;

    /**
     * Crate a new FormBuilder instance.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Build the form.
     *
     * @param null $entry
     */
    public function build($entry = null)
    {
        if ($entry) {
            $this->entry = $entry;
        }

        $this->dispatch(new BuildForm($this));

        if (app('request')->isMethod('post')) {
            $this->dispatch(new HandleFormPost($this->form));
        }
    }

    /**
     * Make the form.
     *
     * @param null $entry
     */
    public function make($entry = null)
    {
        $this->build($entry);

        if ($this->form->getResponse() === null) {

            $this->dispatch(new LoadForm($this->form));

            $options = $this->form->getOptions();
            $data    = $this->form->getData();

            $this->form->setContent(
                view($options->get('form_view', 'streams::ui/form/index'), $data->all())
            );
        }
    }

    /**
     * Render the form.
     *
     * @param  null $entry
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function render($entry = null)
    {
        $this->make($entry);

        if ($this->form->getResponse() === null || $this->form->getResponse() === false) {

            $options = $this->form->getOptions();
            $content = $this->form->getContent();

            return view($options->get('wrapper_view', 'streams::wrappers/blank'), compact('content'));
        }

        return $this->form->getResponse();
    }

    /**
     * Get the form object.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set the form model.
     *
     * @param  $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the form model.
     *
     * @return FormModelInterface|null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the entry object.
     *
     * @param  $entry
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
     * @return null|EntryInterface|mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the fields config.
     *
     * @param  array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get the fields config.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get the skipped fields.
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
     * @param $skips
     * @return $this
     */
    public function setSkips($skips)
    {
        $this->skips = $skips;

        return $this;
    }

    /**
     * Set the actions config.
     *
     * @param  array $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get the actions config.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set the buttons config.
     *
     * @param  $buttons
     * @return $this
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * Get the buttons config.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }
}
