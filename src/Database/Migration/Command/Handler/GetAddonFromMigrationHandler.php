<?php

namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Command\GetAddonFromMigration;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class GetAddonFromMigrationHandler.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class GetAddonFromMigrationHandler
{
    use DispatchesJobs;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * Create a new GetAddonFromMigrationHandler instance.
     *
     * @param AddonCollection $addons
     */
    public function __construct(AddonCollection $addons)
    {
        $this->addons = $addons;
    }

    /**
     * Handle the command.
     *
     * @param GetAddonFromMigration $command
     * @return Addon|null
     */
    public function handle(GetAddonFromMigration $command)
    {
        $matcher = '/(^[a-zA-Z0-9._]+?)(?=__)/';

        $reflection = new \ReflectionClass($command->getMigration());

        $fileName = implode('_', array_slice(explode('_', basename($reflection->getFileName())), 4));

        preg_match($matcher, $fileName, $matches);

        return $this->addons->get(isset($matches[1]) ? $matches[1] : null);
    }
}
