<?php namespace Anomaly\Streams\Platform\Stream\Command;

class AddStreamCommand
{
    /**
     * The stream namespace.
     *
     * @var
     */
    protected $namespace;

    /**
     * The stream slug.
     *
     * @var
     */
    protected $slug;

    /**
     * The stream's table prefix.
     *
     * @var
     */
    protected $prefix;

    /**
     * The stream name.
     *
     * @var
     */
    protected $name;

    /**
     * The stream description.
     *
     * @var
     */
    protected $description;

    /**
     * The default view options for the stream.
     *
     * @var array
     */
    protected $viewOptions;

    /**
     * The stream's title column.
     *
     * @var array
     */
    protected $titleColumn;

    /**
     * The default ordering for the stream.
     *
     * @var
     */
    protected $orderBy;

    /**
     * The stream's hidden flag.
     *
     * @var
     */
    protected $isHidden;

    /**
     * The stream's translatable flag.
     *
     * @var
     */
    protected $isTranslatable;

    /**
     * The stream's revisionable flag.
     *
     * @var
     */
    protected $isRevisionable;

    /**
     * Create a new InstallStreamCommand instance.
     *
     * @param       $namespace
     * @param       $slug
     * @param       $prefix
     * @param       $name
     * @param       $description
     * @param array $viewOptions
     * @param array $titleColumn
     * @param array $orderBy
     * @param       $sortBy
     * @param       $isHidden
     * @param       $isTranslatable
     * @param       $isRevisionable
     */
    function __construct(
        $namespace,
        $slug,
        $prefix,
        $name,
        $description,
        array $viewOptions,
        $titleColumn,
        $orderBy,
        $isHidden,
        $isTranslatable,
        $isRevisionable
    ) {
        $this->name           = $name;
        $this->slug           = $slug;
        $this->prefix         = $prefix;
        $this->orderBy        = $orderBy;
        $this->isHidden       = $isHidden;
        $this->namespace      = $namespace;
        $this->description    = $description;
        $this->titleColumn    = $titleColumn;
        $this->viewOptions    = $viewOptions;
        $this->isRevisionable = $isRevisionable;
        $this->isTranslatable = $isTranslatable;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getIsHidden()
    {
        return $this->isHidden;
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
    public function getName()
    {
        return $this->name;
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
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @return mixed
     */
    public function getTitleColumn()
    {
        return $this->titleColumn;
    }

    /**
     * @return mixed
     */
    public function getViewOptions()
    {
        return $this->viewOptions;
    }
}
 