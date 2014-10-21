<?php namespace Anomaly\Streams\Platform\Stream\Command;

class RemoveStreamCommand
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
     * Create a new UninstallStreamCommand instance.
     *
     * @param $namespace
     * @param $slug
     */
    function __construct($namespace, $slug)
    {
        $this->slug      = $slug;
        $this->namespace = $namespace;
    }

    /**
     * Get the stream namespace.
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the stream slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
 