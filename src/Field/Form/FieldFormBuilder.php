<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Field\Form\Command\AutoAssignField;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldFormBuilder extends FormBuilder
{

    /**
     * The related stream.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

    /**
     * The field namespace.
     *
     * @var null|string
     */
    protected $namespace = null;

    /**
     * The field type.
     *
     * @var null|FieldType
     */
    protected $fieldType = null;

    /**
     * Fired when the builder
     * is ready to build.
     *
     * @throws \Exception
     */
    public function onReady()
    {
        if (!$this->getFieldType() && !$this->getEntry()) {
            throw new \Exception('The $fieldType parameter is required when creating a field.');
        }

        if ((!$this->getStream() && !$this->getNamespace()) && !$this->getEntry()) {
            throw new \Exception('The $stream OR $namespace parameter is required when creating a field.');
        }
    }

    /**
     * Fire just before saving the entry.
     */
    public function onSaving()
    {
        $fieldType = $this->getFieldType();
        $entry     = $this->getFormEntry();
        $namespace = $this->getNamespace();
        $stream    = $this->getStream();

        if (!$entry->namespace) {
            $entry->namespace = $stream ? $stream->getNamespace() : $namespace;
        }

        if (!$entry->type) {
            $entry->type = $fieldType->getNamespace();
        }
    }

    /**
     * Fire after the field is saved.
     */
    public function onSaved()
    {
        $this->dispatch(new AutoAssignField($this));
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface|null
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the stream.
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
     * Get the namespace.
     *
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the namespace.
     *
     * @param $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get the field type.
     *
     * @return FieldType|null
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * Set the field type.
     *
     * @param FieldType $fieldType
     * @return $this
     */
    public function setFieldType(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    /**
     * Get the field's namespace.
     *
     * @return string
     */
    public function getFieldNamespace()
    {
        if ($this->stream) {
            return $this->stream->getNamespace();
        }

        $entry = $this->getFormEntry();

        return $entry->getNamespace();
    }
}
