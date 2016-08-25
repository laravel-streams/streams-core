<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Installer\Installer;
use Anomaly\Streams\Platform\Installer\InstallerCollection;
use Illuminate\Contracts\Console\Kernel;
;

/**
 * Class LoadApplicationInstallers
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console\Command
 */
class LoadApplicationInstallers
{

    /**
     * The installer collection.
     *
     * @var InstallerCollection
     */
    protected $installers;

    /**
     * Create a new LoadApplicationInstallers instance.
     *
     * @param InstallerCollection $installers
     */
    public function __construct(InstallerCollection $installers)
    {
        $this->installers = $installers;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->installers->add(
            new Installer(
                'streams::installer.running_application_migrations',
                function (Kernel $console) {
                    $console->call(
                        'migrate',
                        [
                            '--force'     => true,
                            '--no-addons' => true,
                            '--path'      => 'vendor/anomaly/streams-platform/migrations/application'
                        ]
                    );
                }
            )
        );
    }
}
