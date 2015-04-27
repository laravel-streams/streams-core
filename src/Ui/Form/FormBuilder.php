<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Ui\Form\Command\AddAssets;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildForm;
use Anomaly\Streams\Platform\Ui\Form\Command\LoadForm;
use Anomaly\Streams\Platform\Ui\Form\Command\MakeForm;
use Anomaly\Streams\Platform\Ui\Form\Command\PostForm;
use Anomaly\Streams\Platform\Ui\Form\Command\SaveForm;
use Anomaly\Streams\Platform\Ui\Form\Command\SetFormResponse;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionCollection;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

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
    use FiresCallbacks;

    /**
     * The form model.
     *
     * @var null
     */
    protected $model = null;

    /**
     * The entry object.
     *
     * @var null|int
     */
    protected $entry = null;

    /**
     * The fields config.
     *
     * @var array|string
     */
    protected $fields = [];

    /**
     * Fields to skip.
     *
     * @var array|string
     */
    protected $skips = [];

    /**
     * The actions config.
     *
     * @var array|string
     */
    protected $actions = [];

    /**
     * The buttons config.
     *
     * @var array|string
     */
    protected $buttons = [];

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The form assets.
     *
     * @var array
     */
    protected $assets = [];

    /**
     * The save flag.
     *
     * @var bool
     */
    protected $save = true;

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

        $this->fire('ready', ['builder' => $this]);

        $this->dispatch(new BuildForm($this));

        if (app('request')->isMethod('post')) {
            $this->dispatch(new PostForm($this));
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
            $this->dispatch(new LoadForm($this));
            $this->dispatch(new AddAssets($this));
            $this->dispatch(new MakeForm($this));
        }

        return $this;
    }

    /**
     * Render the form.
     *
     * @param  null $entry
     * @return Response
     */
    public function render($entry = null)
    {
        $this->make($entry);

        if (!$this->form->getResponse()) {
            $this->dispatch(new SetFormResponse($this));
        }

        return $this->form->getResponse();
    }

    /**
     * Save the form.
     */
    public function saveForm()
    {
        $this->dispatch(new SaveForm($this));
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
     * @return null
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
     * @return null|EntryInterface|FieldInterface|mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the fields config.
     *
     * @param  $fields
     * @return $this
     */
    public function setFields($fields)
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
     * Add a skipped field.
     *
     * @param $fieldSlug
     * @return $this
     */
    public function addSkip($fieldSlug)
    {
        $this->skips[] = $fieldSlug;

        return $this;
    }

    /**
     * Set the actions config.
     *
     * @param  $actions
     * @return $this
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Add an action.
     *
     * @param       $slug
     * @param array $definition
     * @return $this
     */
    public function addAction($slug, array $definition = [])
    {
        if ($definition) {
            $this->actions[$slug] = $definition;
        } else {
            $this->actions[] = $slug;
        }

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

    /**
     * The the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get an option value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return array_get($this->options, $key, $default);
    }

    /**
     * Set an option value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        array_set($this->options, $key, $value);

        return $this;
    }

    /**
     * Get the assets.
     *
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Set the assets.
     *
     * @param $assets
     * @return $this
     */
    public function setAssets($assets)
    {
        $this->assets = $assets;

        return $this;
    }

    /**
     * Add an asset.
     *
     * @param $collection
     * @param $asset
     * @return $this
     */
    public function addAsset($collection, $asset)
    {
        if (!isset($this->assets[$collection])) {
            $this->assets[$collection] = [];
        }

        $this->assets[$collection][] = $asset;

        return $this;
    }

    /**
     * Get the form's stream.
     *
     * @return StreamInterface|null
     */
    public function getFormStream()
    {
        return $this->form->getStream();
    }

    /**
     * Get a form option value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getFormOption($key, $default = null)
    {
        return $this->form->getOption($key, $default);
    }

    /**
     * Set a form option value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setFormOption($key, $value)
    {
        $this->form->setOption($key, $value);

        return $this;
    }

    /**
     * Get the form options.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFormOptions()
    {
        return $this->form->getOptions();
    }

    /**
     * Get the form entry.
     *
     * @return EloquentModel|EntryInterface
     */
    public function getFormEntry()
    {
        return $this->form->getEntry();
    }

    /**
     * Get the form mode.
     *
     * @return null|string
     */
    public function getFormMode()
    {
        return $this->form->getMode();
    }

    /**
     * Set the form mode.
     *
     * @param $mode
     * @return $this
     */
    public function setFormMode($mode)
    {
        $this->form->setMode($mode);

        return $this;
    }

    /**
     * Get a form value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getFormValue($key, $default = null)
    {
        return $this->form->getValue($key, $default);
    }

    /**
     * Get the form values.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFormValues()
    {
        return $this->form->getValues();
    }

    /**
     * Get the form input.
     *
     * @return array
     */
    public function getFormInput()
    {
        $values = $this->getFormValues();

        return $values->all();
    }

    /**
     * Get the form data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFormData()
    {
        return $this->form->getData();
    }

    /**
     * Set the form response.
     *
     * @param null|false|Response $response
     * @return $this
     */
    public function setFormResponse(Response $response)
    {
        $this->form->setResponse($response);

        return $this;
    }

    /**
     * Get the form content.
     *
     * @return null|string
     */
    public function getFormContent()
    {
        return $this->form->getContent();
    }

    /**
     * Get the form fields.
     *
     * @return Component\Field\FieldCollection
     */
    public function getFormFields()
    {
        return $this->form->getFields();
    }

    /**
     * Add a form field.
     *
     * @param FieldType $field
     * @return $this
     */
    public function addFormField(FieldType $field)
    {
        $this->form->addField($field);

        return $this;
    }

    /**
     * Set the form errors.
     *
     * @param MessageBag $errors
     * @return $this
     */
    public function setFormErrors(MessageBag $errors)
    {
        $this->form->setErrors($errors);

        return $this;
    }

    /**
     * Get the form errors.
     *
     * @return null|MessageBag
     */
    public function getFormErrors()
    {
        return $this->form->getErrors();
    }

    /**
     * Get the form actions.
     *
     * @return ActionCollection
     */
    public function getFormActions()
    {
        return $this->form->getActions();
    }

    /**
     * Get a request value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getRequestValue($key, $default = null)
    {
        return array_get($_REQUEST, $this->getOption('prefix') . $key, $default);
    }

    /**
     * Set the save flag.
     *
     * @param bool $save
     * @return $this
     */
    public function setSave($save)
    {
        $this->save = $save;

        return $this;
    }

    /**
     * Return the save flag.
     *
     * @return bool
     */
    public function canSave()
    {
        return $this->save;
    }
}
