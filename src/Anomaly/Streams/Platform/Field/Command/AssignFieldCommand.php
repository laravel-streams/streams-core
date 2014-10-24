<?php namespace Anomaly\Streams\Platform\Field\Command;

class AssignFieldCommand
{
    /**
     * @var
     */
    protected $sortOrder;

    /**
     * @var
     */
    protected $namespace;

    /**
     * @var
     */
    protected $stream;

    /**
     * @var
     */
    protected $field;

    /**
     * @var
     */
    protected $label;

    /**
     * @var
     */
    protected $instructions;

    /**
     * @var
     */
    protected $isUnique;

    /**
     * @var
     */
    protected $isRequired;

    /**
     * @var
     */
    protected $isTranslatable;

    /**
     * @var
     */
    protected $isRevisionable;

    /**
     * Create a new AssignFieldCommand instance.
     *
     * @param       $sortOrder
     * @param       $namespace
     * @param       $stream
     * @param       $field
     * @param       $label
     * @param       $instructions
     * @param       $isUnique
     * @param       $isRequired
     * @param       $isTranslatable
     * @param       $isRevisionable
     */
    function __construct(
        $sortOrder,
        $namespace,
        $stream,
        $field,
        $label,
        $instructions,
        $isUnique,
        $isRequired,
        $isTranslatable,
        $isRevisionable
    ) {
        $this->label          = $label;
        $this->field          = $field;
        $this->stream         = $stream;
        $this->isUnique       = $isUnique;
        $this->sortOrder      = $sortOrder;
        $this->namespace      = $namespace;
        $this->isRequired     = $isRequired;
        $this->instructions   = $instructions;
        $this->isRevisionable = $isRevisionable;
        $this->isTranslatable = $isTranslatable;
    }

    /**
     * @return mixed
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * @return mixed
     */
    public function getIsUnique()
    {
        return $this->isUnique;
    }

    /**
     * @return mixed
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * @return mixed
     */
    public function getIsRevisionable()
    {
        return $this->isRevisionable;
    }

    /**
     * @return mixed
     */
    public function getIsTranslatable()
    {
        return $this->isTranslatable;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @return mixed
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }
}
 