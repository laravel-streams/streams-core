<?php namespace Anomaly\Streams\Platform\Addon\Extension\Console;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Exception;

/**
 * Class Uninstall
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Uninstall extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'extension:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall a extension.';

    /**
     * Execute the console command.
     *
     * @param ExtensionManager    $manager
     * @param ExtensionCollection $extensions
     */
    public function handle(ExtensionManager $manager, ExtensionCollection $extensions)
    {
        /* @var Extension $extension */
        $extension = $extensions->get($this->argument('extension'));

        if (!$extension) {
            throw new Exception('Extension ' . $this->argument('extension') . ' does not exist or is not installed.');
        }

        $manager->uninstall($extension);

        $this->info(trans($extension->getName()) . ' uninstalled successfully!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['extension', InputArgument::REQUIRED, 'The extension\'s dot namespace.'],
        ];
    }
}
