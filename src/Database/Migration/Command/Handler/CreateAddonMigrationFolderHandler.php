<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Command\CreateAddonMigrationFolder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class CreateAddonMigrationFolderHandler
 *
 * @package Anomaly\Streams\Platform\Addon\Command\Handler
 */
class CreateAddonMigrationFolderHandler
{
    use DispatchesCommands;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var AddonCollection
     */
    protected $addonCollection;

    /**
     * @param Filesystem      $files
     * @param AddonCollection $addonCollection
     */
    public function __construct(Filesystem $files, AddonCollection $addonCollection)
    {
        $this->files = $files;
        $this->addonCollection = $addonCollection;
    }

    /**
     * @param CreateAddonMigrationFolder $command
     *
     * @return string|null
     */
    public function handle(CreateAddonMigrationFolder $command)
    {
        $path = null;

        if ($addon = $this->addonCollection->merged()->get($command->getNamespace())) {

            $path = $addon->getPath('migrations');

            if (!$this->files->isDirectory($path)) {
                $this->files->makeDirectory($path);
            }
        }

        return $path;
    }

}