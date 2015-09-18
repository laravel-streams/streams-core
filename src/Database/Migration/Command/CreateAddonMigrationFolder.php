<?php

namespace Anomaly\Streams\Platform\Database\Migration\Command;

/**
 * Class CreateAddonMigrationFolder.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class CreateAddonMigrationFolder
{
    /**
     * Get the addon namespace.
     *
     * @var null|string
     */
    protected $addon;

    /**
     * Create a new CreateAddonMigrationFolder instance.
     *
     * @param null|string $namespace
     */
    public function __construct($addon = null)
    {
        $this->addon = $addon;
    }

    /**
     * Get the addon namespace.
     *
     * @return null|string
     */
    public function getAddon()
    {
        return $this->addon;
    }
}
