<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Composer\ClassMapGenerator\ClassMapGenerator;
use Illuminate\Filesystem\Filesystem;

/**
 * Class GenerateEntryModelClassmap
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GenerateEntryModelClassmap
{

    /**
     * Handle the command.
     *
     * @param ClassMapGenerator $generator
     * @param Filesystem $files
     */
    public function handle(Filesystem $files)
    {
        $generator = new ClassMapGenerator;

        foreach ($files->directories(base_path('storage/streams')) as $directory) {
            if (is_dir($models = $directory . '/models')) {

                foreach ($files->directories($models) as $path)
                {
                    $generator->scanPaths($path);
                }

                $classMap = $generator->getClassMap();

                file_put_contents($models . '/classmap.php', sprintf('<?php return %s;', var_export($classMap->getMap(), true)));
            }
        }
    }
}
