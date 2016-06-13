<?php namespace Anomaly\Streams\Platform\Installer\Console;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Application\Command\ReloadEnvironmentFile;
use Anomaly\Streams\Platform\Application\Command\WriteEnvironmentFile;
use Anomaly\Streams\Platform\Installer\Console\Command\ConfigureDatabase;
use Anomaly\Streams\Platform\Installer\Console\Command\ConfirmLicense;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadApplicationInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadCoreInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\LocateApplication;
use Anomaly\Streams\Platform\Installer\Console\Command\RunInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\SetAdminData;
use Anomaly\Streams\Platform\Installer\Console\Command\SetApplicationData;
use Anomaly\Streams\Platform\Installer\Console\Command\SetDatabaseData;
use Anomaly\Streams\Platform\Installer\Console\Command\SetDatabasePrefix;
use Anomaly\Streams\Platform\Installer\Console\Command\SetOtherData;
use Anomaly\Streams\Platform\Installer\Console\Command\SetStreamsData;
use Anomaly\Streams\Platform\Installer\Event\StreamsHasInstalled;
use Anomaly\Streams\Platform\Installer\Installer;
use Anomaly\Streams\Platform\Installer\InstallerCollection;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Install
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console
 */
class Install extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Streams Platform.';

    /**
     * Execute the console command.
     */
    public function fire(Dispatcher $events, Application $application, AddonManager $manager)
    {
        $this->dispatch(new ConfirmLicense($this));

        $data = new Collection();

        $this->dispatch(new SetStreamsData($data));
        $this->dispatch(new SetDatabaseData($data, $this));
        $this->dispatch(new SetApplicationData($data, $this));
        $this->dispatch(new SetAdminData($data, $this));
        $this->dispatch(new SetOtherData($data, $this));

        $this->dispatch(new WriteEnvironmentFile($data->all()));
        $this->dispatch(new ReloadEnvironmentFile());

        $this->dispatch(new ConfigureDatabase());
        $this->dispatch(new SetDatabasePrefix());
        $this->dispatch(new LocateApplication());

        $installers = new InstallerCollection();

        $this->dispatch(new LoadCoreInstallers($installers));
        $this->dispatch(new LoadApplicationInstallers($installers));
        $this->dispatch(new LoadModuleInstallers($installers));
        $this->dispatch(new LoadExtensionInstallers($installers));

        $this->dispatch(new RunInstallers($installers, $this));

        $this->call('env:set', ['line' => 'INSTALLED=true']);

        $this->dispatch(new ReloadEnvironmentFile());

        $installers->add(
            new Installer(
                'streams::installer.running_migrations',
                function (Kernel $console) {
                    $console->call('migrate', ['--force' => true, '--no-addons' => true]);
                }
            )
        );

        $manager->register(); // Register all of our addons.

        $events->fire(new StreamsHasInstalled($installers));

        $this->info('Running post installation tasks.');

        $this->dispatch(new LoadModuleSeeders($installers));
        $this->dispatch(new LoadExtensionSeeders($installers));

        $installers->add(
            new Installer(
                'streams::installer.running_seeds',
                function (Kernel $console) {
                    $console->call('db:seed');
                }
            )
        );

        $this->dispatch(new RunInstallers($installers, $this));
    }
}
