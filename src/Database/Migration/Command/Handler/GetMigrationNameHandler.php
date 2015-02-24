<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Command\GetMigrationName;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class GetMigrationNameHandler
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class GetMigrationNameHandler
{
    use DispatchesCommands;

    /**
     * @var AddonCollection
     */
    protected $addonCollection;

    /**
     * @param AddonCollection $addonCollection
     */
    public function __construct(AddonCollection $addonCollection)
    {
        $this->addonCollection = $addonCollection;
    }

    /**
     * @param GetMigrationName $command
     *
     * @return string
     */
    public function handle(GetMigrationName $command)
    {
        $namespace = $command->getNamespace();

        $name = $originalName = $command->getName();

        if ($addon = $this->addonCollection->merged()->get($namespace)) {

            $name = "{$namespace}__{$originalName}";

            // Append the package version if there is one
            if ($json = $addon->getComposerJson()) {
                if (property_exists($json, 'version')) {
                    $name = "{$namespace}__{$json->version}__{$originalName}";
                }
            }
        }

        return $name;
    }

}