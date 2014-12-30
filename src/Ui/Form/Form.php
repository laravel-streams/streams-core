<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

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

    public function __construct(
        Collection $data,
        Collection $fields,
        Collection $options
    ) {
        $this->data    = $data;
        $this->fields  = $fields;
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
     * @return Collection
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
