<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldCollection;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Form
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form
 */
class Form
{

    use FiresCallbacks;

    /**
     * The form model.
     *
     * @var null|mixed
     */
    protected $model = null;

    /**
     * The form repository.
     *
     * @var null|FormRepositoryInterface
     */
    protected $repository = null;

    /**
     * The form stream.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

    /**
     * The form entry.
     *
     * @var mixed
     */
    protected $entry = null;

    /**
     * The form content.
     *
     * @var null|string
     */
    protected $content = null;

    /**
     * The form response.
     *
     * @var null|Response
     */
    protected $response = null;

    /**
     * The form errors.
     *
     * @var null|array
     */
    protected $errors = null;

    /**
     * The form model. This is set
     * to create / edit automatically.
     *
     * @var null|string
     */
    protected $mode = null;

    /**
     * The form data.
     *
     * @var Collection
     */
    protected $data;

    /**
     * The form values.
     *
     * @var Collection
     */
    protected $values;

    /**
     * The form fields.
     *
     * @var Collection
     */
    protected $fields;

    /**
     * The form options.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $options;

    /**
     * The form actions.
     *
     * @var Component\Action\ActionCollection
     */
    protected $actions;

    /**
     * The form buttons.
     *
     * @var ButtonCollection
     */
    protected $buttons;

    /**
     * Create a new Form instance.
     *
     * @param Collection       $data
     * @param Collection       $values
     * @param Collection       $options
     * @param FieldCollection  $fields
     * @param ActionCollection $actions
     * @param ButtonCollection $buttons
     */
    public function __construct(
        Collection $data,
        Collection $values,
        Collection $options,
        FieldCollection $fields,
        ActionCollection $actions,
        ButtonCollection $buttons
    ) {
        $this->data    = $data;
        $this->values  = $values;
        $this->fields  = $fields;
        $this->actions = $actions;
        $this->buttons = $buttons;
        $this->options = $options;
    }

    /**
     * Save the form.
     *
     * @return bool|mixed
     */
    public function save()
    {
        return $this->repository->save($this);
    }

    /**
     * Set the form response.
     *
     * @param null|false|Response $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the form response.
     *
     * @return null|Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the errors.
     *
     * @return array|null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the errors.
     *
     * @param $errors
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Set the model object.
     *
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model object.
     *
     * @return null|EloquentModel|EntryModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get the form repository.
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
     * Set the form stream.
     *
     * @param StreamInterface $stream
     * @return $this
     */
    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the form stream.
     *
     * @return null|StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the entry.
     *
     * @param mixed $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the entry.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the form content.
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the form content.
     *
     * @return null|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add an action to the actions collection.
     *
     * @param ActionInterface $action
     * @return $this
     */
    public function addAction(ActionInterface $action)
    {
        $this->actions->put($action->getSlug(), $action);

        return $this;
    }

    /**
     * Set the form actions.
     *
     * @param ActionCollection $actions
     * @return $this
     */
    public function setActions(ActionCollection $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get the form actions.
     *
     * @return ActionCollection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Add a button to the buttons collection.
     *
     * @param ButtonInterface $button
     * @return $this
     */
    public function addButton(ButtonInterface $button)
    {
        $this->buttons->push($button);

        return $this;
    }

    /**
     * Set the form buttons.
     *
     * @param ButtonCollection $buttons
     * @return $this
     */
    public function setButtons(ButtonCollection $buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * Get the form buttons.
     *
     * @return ButtonCollection
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the options.
     *
     * @param Collection $options
     * @return $this
     */
    public function setOptions(Collection $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the options.
     *
     * @return Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set an option.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options->put($key, $value);

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
        return $this->options->get($key, $default);
    }

    /**
     * Add a field to the collection of fields.
     *
     * @param FieldType $field
     * @return $this
     */
    public function addField(FieldType $field)
    {
        $this->fields->push($field);

        return $this;
    }

    /**
     * Set the form views.
     *
     * @param Collection $fields
     * @return $this
     */
    public function setFields(Collection $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get the form fields.
     *
     * @return FieldCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get a form field.
     *
     * @param $key
     * @return FieldType|mixed
     */
    public function getField($key)
    {
        return $this->fields->get($key);
    }

    /**
     * Add data to the view data collection.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->data->put($key, $value);

        return $this;
    }

    /**
     * Set the form data.
     *
     * @param Collection $data
     * @return $this
     */
    public function setData(Collection $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the form data.
     *
     * @return Collection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set a value on the value collection.
     *
     * @param $key
     * @param $value
     */
    public function setValue($key, $value)
    {
        $this->values->put($key, $value);
    }

    /**
     * Get a value from the value collection.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function getValue($key, $default = null)
    {
        return $this->values->get($key, $default);
    }

    /**
     * Set the form values.
     *
     * @param Collection $values
     * @return $this
     */
    public function setValues(Collection $values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Get the form values.
     *
     * @return Collection
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Get the mode.
     *
     * @return null|string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set the mode.
     *
     * @param $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }
}
