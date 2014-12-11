<?php namespace Anomaly\Streams\Platform\Stream\Command;

/**
 * Class DeleteStreamCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Command
 */
class DeleteStreamCommand
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
     * Create a new DeleteStreamCommand instance.
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
