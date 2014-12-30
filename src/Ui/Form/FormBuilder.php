<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * The form handler.
     *
     * @var string
     */
    protected $handler = 'Anomaly\Streams\Platform\Ui\Form\FormHandler@handle';

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
    protected $fields = [];

    /**
     * The actions config.
     *
     * @var array
     */
    protected $actions = [];

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

        $this->initialize();
    }

    /**
     * Initialize the table builder.
     */
    protected function initialize()
    {
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

        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\BuildFormCommand', ['builder' => $this]);

        if (app('request')->isMethod('post')) {
            $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\HandleFormPostCommand', ['builder' => $this]);
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

            $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\LoadFormCommand', ['form' => $this->form]);

            $options = $this->form->getOptions();
            $data    = $this->form->getData();

            $this->form->setContent(
                view($options->get('view', 'streams::ui/form/index'), $data->all())
            );
        }
    }

    /**
     * Render the form.
     *
     * @param  null $entry
     * @return \Illuminate\View\View|null
     */
    public function render($entry = null)
    {
        $this->make($entry);

        if ($this->form->getResponse() === null || $this->form->getResponse() === false) {

            $options = $this->form->getOptions();
            $content = $this->form->getContent();

            return view($options->get('wrapper', 'streams::wrappers/blank'), compact('content'));
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
     * Set the form handler.
     *
     * @param  $handler
     * @return $this
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get the form handler.
     *
     * @return string
     */
    public function getHandler()
    {
        return $this->handler;
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
     * @return null
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
    public function setFields(array $sections)
    {
        $this->sections = $sections;

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
