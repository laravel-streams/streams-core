<?php namespace Anomaly\Streams\Platform\Field\Command;

/**
 * Class DeleteFieldCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class DeleteFieldCommand
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
     * Create a new DeleteFieldCommand instance.
     *
     * @param $namespace
     * @param $slug
     */
    public function __construct($namespace, $slug)
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
