<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Form\Command\AddAssets;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildForm;
use Anomaly\Streams\Platform\Ui\Form\Command\LoadForm;
use Anomaly\Streams\Platform\Ui\Form\Command\MakeForm;
use Anomaly\Streams\Platform\Ui\Form\Command\PopulateFields;
use Anomaly\Streams\Platform\Ui\Form\Command\PostForm;
use Anomaly\Streams\Platform\Ui\Form\Command\SaveForm;
use Anomaly\Streams\Platform\Ui\Form\Command\SetFormResponse;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
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

    use DispatchesJobs;
    use FiresCallbacks;

    /**
     * The ajax flag.
     *
     * @var bool
     */
    protected $ajax = false;

    /**
     * The form handler.
     *
     * @var null|string
     */
    protected $handler = null;

    /**
     * The form validator.
     *
     * @var null|string
     */
    protected $validator = null;

    /**
     * The form repository.
     *
     * @var null|FormRepositoryInterface
     */
    protected $repository = null;

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
     * The form sections.
     *
     * @var array
     */
    protected $sections = [];

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
     * The read only flag.
     *
     * @var bool
     */
    protected $readOnly = false;

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
     * @return $this
     */
    public function build($entry = null)
    {
        if ($entry) {
            $this->entry = $entry;
        }

        $this->fire('ready', ['builder' => $this]);

        $this->dispatch(new BuildForm($this));

        return $this;
    }

    /**
     * Make the form.
     *
     * @param null $entry
     * @return $this
     */
    public function make($entry = null)
    {
        $this->build($entry);
        $this->post();

        if ($this->getFormResponse() === null) {
            $this->dispatch(new LoadForm($this));
            $this->dispatch(new AddAssets($this));
            $this->dispatch(new MakeForm($this));
        }

        return $this;
    }

    /**
     * Handle the form post.
     *
     * @param null $entry
     * @throws \Exception
     */
    public function handle($entry = null)
    {
        if (!app('request')->isMethod('post')) {
            throw new \Exception('The handle method must be used with a POST request.');
        }

        $this->build($entry);
        $this->post();
    }

    /**
     * Trigger post operations
     * for the form.
     *
     * @return $this
     */
    public function post()
    {
        if (app('request')->isMethod('post') && $this->hasPostData()) {
            $this->dispatch(new PostForm($this));
        } else {
            $this->dispatch(new PopulateFields($this));
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
     * Fire field events.
     *
     * @param       $trigger
     * @param array $payload
     */
    public function fireFieldEvents($trigger, array $payload = [])
    {
        /* @var FieldType $field */
        foreach ($this->getFormFields() as $field) {
            $field->fire($trigger, array_merge(['builder' => $this], $payload));
        }
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
     * Get the form presenter.
     *
     * @return FormPresenter
     */
    public function getFormPresenter()
    {
        return $this->form->getPresenter();
    }

    /**
     * Get the ajax flag.
     *
     * @return bool
     */
    public function isAjax()
    {
        return $this->ajax;
    }

    /**
     * Set the ajax flag.
     *
     * @param $ajax
     * @return $this
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;

        return $this;
    }

    /**
     * Get the handler.
     *
     * @return null|string
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Set the handler.
     *
     * @param $handler
     * @return $this
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get the validator.
     *
     * @return null|string
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set the validator.
     *
     * @param $validator
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get the repository.
     *
     * @return FormRepositoryInterface|null
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Set the form repository.
     *
     * @param FormRepositoryInterface $repository
     * @return $this
     */
    public function setRepository(FormRepositoryInterface $repository)
    {
        $this->repository = $repository;

        return $this;
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
     * Set the fields.
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
     * Get the fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Add a field.
     *
     * @param $field
     */
    public function addField($field)
    {
        $this->fields[] = $field;
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
    public function skipField($fieldSlug)
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
     * @param array|string $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Merge in options.
     *
     * @param array|string $options
     * @return $this
     */
    public function mergeOptions($options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * Get the sections.
     *
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set the sections.
     *
     * @param array|Closure $sections
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
     * @param       $slug
     * @param array $section
     * @return $this
     */
    public function addSection($slug, array $section)
    {
        array_set($this->sections, $slug, $section);

        return $this;
    }

    /**
     * Add a section tab.
     *
     * @param       $section
     * @param       $slug
     * @param array $tab
     * @return $this
     */
    public function addSectionTab($section, $slug, array $tab)
    {
        array_set($this->sections, "{$section}.tabs.{$slug}", $tab);

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
     * @return \Anomaly\Streams\Platform\Support\Collection
     */
    public function getFormOptions()
    {
        return $this->form->getOptions();
    }

    /**
     * Get the form model.
     *
     * @return \Anomaly\Streams\Platform\Entry\EntryModel|EloquentModel|null
     */
    public function getFormModel()
    {
        return $this->form->getModel();
    }

    /**
     * Get the form entry.
     *
     * @return EloquentModel|EntryInterface|FieldInterface|AssignmentInterface
     */
    public function getFormEntry()
    {
        return $this->form->getEntry();
    }

    /**
     * Return the form entry's ID.
     *
     * @return int|mixed|null
     */
    public function getFormEntryId()
    {
        $entry = $this->getFormEntry();

        return $entry->getId();
    }

    /**
     * Get the contextual entry ID.
     *
     * @return int|null
     */
    public function getContextualId()
    {
        return $this->getFormEntryId();
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
     * Set a form value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setFormValue($key, $value)
    {
        $this->form->setValue($key, $value);

        return $this;
    }

    /**
     * Get the form values.
     *
     * @return \Anomaly\Streams\Platform\Support\Collection
     */
    public function getFormValues()
    {
        return $this->form->getValues();
    }

    /**
     * Reset the form.
     *
     * @return $this
     */
    public function resetForm()
    {
        $this->form
            ->resetFields()
            ->setValues(new Collection());

        return $this;
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
     * @return \Anomaly\Streams\Platform\Support\Collection
     */
    public function getFormData()
    {
        return $this->form->getData();
    }

    /**
     * Ge the form response.
     *
     * @return null|Response
     */
    public function getFormResponse()
    {
        return $this->form->getResponse();
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
     * Get the enabled form fields.
     *
     * @return Component\Field\FieldCollection
     */
    public function getEnabledFormFields()
    {
        return $this->form->getEnabledFields();
    }

    /**
     * Get the form field.
     *
     * @param $fieldSlug
     * @return FieldType
     */
    public function getFormField($fieldSlug)
    {
        return $this->form->getField($fieldSlug);
    }

    /**
     * Get the form attribute map.
     *
     * @return FieldType
     */
    public function getFormFieldFromAttribute($attribute)
    {
        /* @var FieldType $field */
        foreach ($this->form->getFields() as $field) {
            if ($field->getInputName() == $attribute) {
                return $field;
            }
        }

        return null;
    }

    /**
     * Disable a form field.
     *
     * @param $fieldSlug
     * @return FieldType
     */
    public function disableFormField($fieldSlug)
    {
        return $this->form->disableField($fieldSlug);
    }

    /**
     * Get the form field slugs.
     *
     * @return array
     */
    public function getFormFieldSlugs()
    {
        $fields = $this->form->getFields();

        return $fields->lists('field')->all();
    }

    /**
     * Get the form field names.
     *
     * @return array
     */
    public function getFormFieldNames()
    {
        $fields = $this->form->getFields();

        return $fields->lists('field_name')->all();
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
     * Add an error to the form.
     *
     * @param $field
     * @param $message
     * @return $this
     */
    public function addFormError($field, $message)
    {
        $errors = $this->getFormErrors();

        $errors->add($field, $message);

        return $this;
    }

    /**
     * Return whether the form has errors or not.
     *
     * @return bool
     */
    public function hasFormErrors()
    {
        $errors = $this->form->getErrors();

        return !$errors->isEmpty();
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
     * Add a form button.
     *
     * @param ButtonInterface $button
     * @return $this
     */
    public function addFormButton(ButtonInterface $button)
    {
        $this->form->addButton($button);

        return $this;
    }

    /**
     * Add a form section.
     *
     * @param       $slug
     * @param array $section
     * @return $this
     */
    public function addFormSection($slug, array $section)
    {
        $this->form->addSection($slug, $section);

        return $this;
    }

    /**
     * Set the form entry.
     *
     * @param $entry
     * @return $this
     */
    public function setFormEntry($entry)
    {
        $this->form->setEntry($entry);

        return $this;
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
     * Get a post value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getPostValue($key, $default = null)
    {
        return array_get($_POST, $this->getOption('prefix') . $key, $default);
    }

    /**
     * Return a post key flag.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function hasPostValue($key)
    {
        return isset($_POST[$this->getOption('prefix') . $key]);
    }

    /**
     * Return whether any post data exists.
     *
     * @return bool
     */
    public function hasPostData()
    {
        /* @var FieldType $field */
        foreach ($this->getFormFields() as $field) {
            if ($field->getPostValue()) {
                return true;
            }
        }

        return false;
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

    /**
     * Set the read only flag.
     *
     * @param $readOnly
     * @return $this
     */
    public function setReadOnly($readOnly)
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * Return the read only flag.
     *
     * @return bool
     */
    public function isReadOnly()
    {
        return $this->readOnly;
    }
}
