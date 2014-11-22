<?php namespace Anomaly\Streams\Platform\Field\Command;

/**
 * Class AssignFieldCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Command
 */
class AssignFieldCommand
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
    protected $isUnique;

    /**
     * The required flag.
     *
     * @var
     */
    protected $isRequired;

    /**
     * The translatable flag.
     *
     * @var
     */
    protected $isTranslatable;

    /**
     * Create a new AssignFieldCommand instance.
     *
     * @param      $namespace
     * @param      $stream
     * @param      $field
     * @param null $label
     * @param int  $sortOrder
     * @param bool $isUnique
     * @param bool $isRequired
     * @param null $placeholder
     * @param null $instructions
     * @param bool $isTranslatable
     */
    function __construct(
        $namespace,
        $stream,
        $field,
        $label = null,
        $sortOrder = 0,
        $isUnique = false,
        $isRequired = false,
        $placeholder = null,
        $instructions = null,
        $isTranslatable = false
    ) {
        $this->label          = $label;
        $this->field          = $field;
        $this->stream         = $stream;
        $this->isUnique       = $isUnique;
        $this->sortOrder      = $sortOrder;
        $this->namespace      = $namespace;
        $this->isRequired     = $isRequired;
        $this->placeholder    = $placeholder;
        $this->instructions   = $instructions;
        $this->isTranslatable = $isTranslatable;
    }

    /**
     * Get the required flag.
     *
     * @return mixed
     */
    public function getIsRequired()
    {
        return $this->isRequired;
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
    public function getIsUnique()
    {
        return $this->isUnique;
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
    public function getIsTranslatable()
    {
        return $this->isTranslatable;
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
 