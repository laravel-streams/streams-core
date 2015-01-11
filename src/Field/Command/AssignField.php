<?php namespace Anomaly\Streams\Platform\Field\Command;

/**
 * Class AssignField
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class AssignField
{

    /**
     * The sort order.
     *
     * @var
     */
    protected $sortOrder;

    /**
     * The field namespace.
     *
     * @var
     */
    protected $namespace;

    /**
     * The stream slug.
     *
     * @var
     */
    protected $stream;

    /**
     * The field slug.
     *
     * @var
     */
    protected $field;

    /**
     * The label.
     *
     * @var
     */
    protected $label;

    /**
     * The placeholder.
     *
     * @var
     */
    protected $placeholder;

    /**
     * The instructions.
     *
     * @var
     */
    protected $instructions;

    /**
     * The unique flag.
     *
     * @var
     */
    protected $unique;

    /**
     * The required flag.
     *
     * @var
     */
    protected $required;

    /**
     * The translatable flag.
     *
     * @var
     */
    protected $translatable;

    /**
     * Create a new AssignField instance.
     *
     * @param      $namespace
     * @param      $stream
     * @param      $field
     * @param null $label
     * @param int  $sortOrder
     * @param bool $unique
     * @param bool $required
     * @param null $placeholder
     * @param null $instructions
     * @param bool $translatable
     */
    public function __construct(
        $namespace,
        $stream,
        $field,
        $label = null,
        $sortOrder = 0,
        $unique = false,
        $required = false,
        $placeholder = null,
        $instructions = null,
        $translatable = false
    ) {
        $this->label        = $label;
        $this->field        = $field;
        $this->stream       = $stream;
        $this->unique       = $unique;
        $this->sortOrder    = $sortOrder;
        $this->namespace    = $namespace;
        $this->required     = $required;
        $this->placeholder  = $placeholder;
        $this->instructions = $instructions;
        $this->translatable = $translatable;
    }

    /**
     * Get the required flag.
     *
     * @return mixed
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Get the placeholder.
     *
     * @return mixed
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Get the unique flag.
     *
     * @return mixed
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * Get the instructions.
     *
     * @return mixed
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Get the translatable flag.
     *
     * @return mixed
     */
    public function isTranslatable()
    {
        return $this->translatable;
    }

    /**
     * Get the label.
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the field namespace.
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the sort order.
     *
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * Get the stream slug.
     *
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }
}
