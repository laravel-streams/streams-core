<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

/**
 * Class CreateAddonMigrationFolder
 *
 * @package Anomaly\Streams\Platform\Addon\Command
 */
class CreateAddonMigrationFolder
{

    /**
     * @var null
     */
    protected $namespace;

    /**
     * @param null $namespace
     */
    public function __construct($namespace = null)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

}