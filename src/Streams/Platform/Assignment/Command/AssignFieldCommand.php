<?php namespace Streams\Platform\Assignment\Command;

class AssignFieldCommand
{
    /**
     * The assignment sort order.
     *
     * @var
     */
    protected $sortOrder;

    /**
     * The assignment stream id.
     *
     * @var
     */
    protected $streamId;

    /**
     * The assignment field id.
     *
     * @var
     */
    protected $fieldId;

    /**
     * The assignment name.
     *
     * @var
     */
    protected $name;

    /**
     * The assignment instructions.
     *
     * @var
     */
    protected $instructions;

    /**
     * The assignment's required flag.
     *
     * @var
     */
    protected $isRequired;

    /**
     * The assignment's unique flag.
     *
     * @var
     */
    protected $isUnique;

    /**
     * The assignment's translatable flag.
     *
     * @var
     */
    protected $isTranslatable;

    /**
     * The assignment's revisionable flag.
     *
     * @var
     */
    protected $isRevisionable;

    /**
     * Create a new InstallAssignmentCommand instance.
     *
     * @param $sortOrder
     * @param $streamId
     * @param $fieldId
     * @param $name
     * @param $instructions
     * @param $isRequired
     * @param $isUnique
     * @param $isTranslatable
     * @param $isRevisionable
     */
    function __construct(
        $sortOrder,
        $streamId,
        $fieldId,
        $name,
        $instructions,
        $isRequired,
        $isUnique,
        $isTranslatable,
        $isRevisionable
    ) {
        $this->name           = $name;
        $this->fieldId        = $fieldId;
        $this->isUnique       = $isUnique;
        $this->streamId       = $streamId;
        $this->sortOrder      = $sortOrder;
        $this->isRequired     = $isRequired;
        $this->instructions   = $instructions;
        $this->isRevisionable = $isRevisionable;
        $this->isTranslatable = $isTranslatable;
    }

    /**
     * @return mixed
     */
    public function getFieldId()
    {
        return $this->fieldId;
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
    public function getIsRequired()
    {
        return $this->isRequired;
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
    public function getIsUnique()
    {
        return $this->isUnique;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
    public function getStreamId()
    {
        return $this->streamId;
    }
}
 