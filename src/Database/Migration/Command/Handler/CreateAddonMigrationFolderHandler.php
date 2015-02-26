<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Command\CreateAddonMigrationFolder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class CreateAddonMigrationFolderHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class CreateAddonMigrationFolderHandler
{

    use DispatchesCommands;

    /**
     * The file system.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * @param Filesystem      $files
     * @param AddonCollection $addons
     */
    public function __construct(Filesystem $files, AddonCollection $addons)
    {
        $this->files  = $files;
        $this->addons = $addons;
    }

    /**
     * Handle the command.
     *
     * @param CreateAddonMigrationFolder $command
     * @return string|null
     */
    public function handle(CreateAddonMigrationFolder $command)
    {
        $path = null;

        if ($addon = $this->addons->merged()->get($command->getNamespace())) {

            $path = $addon->getPath('migrations');

            if (!$this->files->isDirectory($path)) {
                $this->files->makeDirectory($path);
            }
        }

        return $path;
    }
}
