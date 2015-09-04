<?php namespace Anomaly\Streams\Platform\Addon\Extension\Console;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Uninstall
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console
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
    public function fire(ExtensionManager $manager, ExtensionCollection $extensions)
    {
        /* @var Extension $extension*/
        $extension = $extensions->get($this->argument('extension'));

        $extension->fire('installing');

        $manager->uninstall($extension);

        $extension->fire('installed');

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
