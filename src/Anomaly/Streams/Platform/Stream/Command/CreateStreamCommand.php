<?php namespace Anomaly\Streams\Platform\Stream\Command;

/**
 * Class CreateStreamCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Command
 */
class CreateStreamCommand
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
    protected $hidden;

    /**
     * The stream's translatable flag.
     *
     * @var
     */
    protected $translatable;

    /**
     * Create a new CreateStreamCommand instance.
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
     * @param       $hidden
     * @param       $translatable
     */
    public function __construct(
        $namespace,
        $slug,
        $prefix,
        $name,
        $description,
        array $viewOptions,
        $titleColumn,
        $orderBy,
        $hidden,
        $translatable
    ) {
        $this->name         = $name;
        $this->slug         = $slug;
        $this->prefix       = $prefix;
        $this->orderBy      = $orderBy;
        $this->hidden       = $hidden;
        $this->namespace    = $namespace;
        $this->description  = $description;
        $this->titleColumn  = $titleColumn;
        $this->viewOptions  = $viewOptions;
        $this->translatable = $translatable;
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
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @return mixed
     */
    public function isTranslatable()
    {
        return $this->translatable;
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
