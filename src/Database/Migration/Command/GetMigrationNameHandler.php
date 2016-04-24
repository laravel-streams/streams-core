<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Command\GetMigrationName;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class GetMigrationNameHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class GetMigrationNameHandler
{

    use DispatchesJobs;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * Create a new GetMigrationNameHandler instance.
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
     * @param GetMigrationName $command
     * @return string
     */
    public function handle(GetMigrationName $command)
    {
        $namespace = $command->getNamespace();

        $name = $originalName = $command->getName();

        if ($addon = $this->addons->get($namespace)) {

            $name = "{$namespace}__{$originalName}";

            // Append the package version if there is one.
            if ($json = $addon->getComposerJson()) {
                if (property_exists($json, 'version')) {

                    $version = str_slug(str_replace(['.', '-'], '_', $json->version), '_');

                    $name = "{$namespace}__{$version}__{$originalName}";
                }
            }
        }

        return $name;
    }
}
