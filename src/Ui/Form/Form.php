<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldCollection;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
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

    /**
     * The form model.
     *
     * @var null|FormModelInterface
     */
    protected $model = null;

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
     * The form data.
     *
     * @var Collection
     */
    protected $data;

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
     * @param Collection       $options
     * @param FieldCollection  $fields
     * @param ActionCollection $actions
     * @param ButtonCollection $buttons
     */
    public function __construct(
        Collection $data,
        Collection $options,
        FieldCollection $fields,
        ActionCollection $actions,
        ButtonCollection $buttons
    ) {
        $this->data    = $data;
        $this->fields  = $fields;
        $this->actions = $actions;
        $this->buttons = $buttons;
        $this->options = $options;
    }

    /**
     * Set the form response.
     *
     * @param null|Response $response
     * @return $this
     */
    public function setResponse(Response $response = null)
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
     * @return null|FormModelInterface
     */
    public function getModel()
    {
        return $this->model;
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
}
