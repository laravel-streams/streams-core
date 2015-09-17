<?php

namespace Anomaly\Streams\Platform\Database\Migration\Command;

/**
 * Class GetMigrationName.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class GetMigrationName
{
    /**
     * The migration name.
     *
     * @var string
     */
    protected $name;

    /**
     * The namespace.
     *
     * @var string|null
     */
    protected $namespace = null;

    /**
     * Create a new GetMigrationName instance.
     *
     * @param $name
     * @param $namespace
     */
    public function __construct($name, $namespace = null)
    {
        $this->name      = $name;
        $this->namespace = $namespace;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the namespace.
     *
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
