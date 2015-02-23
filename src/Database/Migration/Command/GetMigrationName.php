<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

/**
 * Class GetMigrationName
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command
 */
class GetMigrationName
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $namespace = null;

    /**
     * @param $name
     * @param $namespace
     */
    public function __construct($name, $namespace = null)
    {
        $this->name = $name;
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

}