<?php namespace Anomaly\Streams\Platform\Field\Command;

class RemoveFieldCommand
{

    /**
     * The field namespace.
     *
     * @var
     */
    protected $namespace;

    /**
     * The field slug.
     *
     * @var
     */
    protected $slug;

    /**
     * Create a new UninstallFieldCommand instance.
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
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
 