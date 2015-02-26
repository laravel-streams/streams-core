<?php namespace Anomaly\Streams\Platform\Addon\Command;


class GetAddonByNamespace
{

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @param $namespace
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

}