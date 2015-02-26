<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

/**
 * Class CreateAddonMigrationFolder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class CreateAddonMigrationFolder
{

    /**
     * Get the migration folder.
     *
     * @var null|string
     */
    protected $namespace;

    /**
     * Create a new CreateAddonMigrationFolder instance.
     *
     * @param null|string $namespace
     */
    public function __construct($namespace = null)
    {
        $this->namespace = $namespace;
    }

    /**
     * Get the namespace.
     *
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
