<?php

namespace Anomaly\Streams\Platform\Installer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Support\Collection;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Installer\Installer;
use Anomaly\Streams\Platform\Installer\InstallerCollection;
use Anomaly\Streams\Platform\Entry\Command\AutoloadEntryModels;
use Anomaly\Streams\Platform\Installer\Console\Command\SetAdminData;
use Anomaly\Streams\Platform\Installer\Console\Command\SetOtherData;
use Anomaly\Streams\Platform\Installer\Console\Command\RunInstallers;
use Anomaly\Streams\Platform\Application\Command\WriteEnvironmentFile;
use Anomaly\Streams\Platform\Installer\Console\Command\ConfirmLicense;
use Anomaly\Streams\Platform\Installer\Console\Command\SetStreamsData;
use Anomaly\Streams\Platform\Application\Command\InitializeApplication;
use Anomaly\Streams\Platform\Application\Command\ReloadEnvironmentFile;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadBaseSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\SetDatabaseData;
use Anomaly\Streams\Platform\Installer\Console\Command\ConfigureDatabase;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\SetDatabasePrefix;
use Anomaly\Streams\Platform\Application\Command\LoadEnvironmentOverrides;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadBaseMigrations;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadCoreInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\SetApplicationData;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadApplicationInstallers;

class Install extends Command
{

    protected $name = 'install';

    protected $description = 'Install the Streams Platform.';

    public function handle(AddonManager $manager)
    {
        $data = new Collection();

        if (!$this->option('ready')) {

            dispatch_sync(new ConfirmLicense($this));
            dispatch_sync(new SetStreamsData($data));
            dispatch_sync(new SetDatabaseData($data, $this));
            dispatch_sync(new SetApplicationData($data, $this));
            dispatch_sync(new SetAdminData($data, $this));
            dispatch_sync(new SetOtherData($data, $this));

            dispatch_sync(new WriteEnvironmentFile($data->all()));
        }

        dispatch_sync(new ReloadEnvironmentFile());
        dispatch_sync(new LoadEnvironmentOverrides());
        dispatch_sync(new InitializeApplication());

        dispatch_sync(new ConfigureDatabase());

        DB::purge(Config::get('database.default'));

        dispatch_sync(new SetDatabasePrefix());

        $installers = new InstallerCollection();

        dispatch_sync(new LoadCoreInstallers($installers));
        dispatch_sync(new LoadApplicationInstallers($installers));
        dispatch_sync(new LoadModuleInstallers($installers));
        dispatch_sync(new LoadExtensionInstallers($installers));

        $installers->push(
            new Installer(
                'streams::installer.reloading_application',
                function () use ($manager) {

                    $this->call('env:set', ['line' => 'INSTALLED=true']);

                    dispatch_sync(new ReloadEnvironmentFile());
                    dispatch_sync(new AutoloadEntryModels()); // Don't forget!

                    $manager->register(true); // Register all of our addons.

                    dispatch_sync(new AutoloadEntryModels()); // Yes, again.
                }
            )
        );

        dispatch_sync(new LoadModuleSeeders($installers));
        dispatch_sync(new LoadExtensionSeeders($installers));

        dispatch_sync(new LoadBaseMigrations($installers));
        dispatch_sync(new LoadBaseSeeders($installers));

        dispatch_sync(new RunInstallers($installers, $this));
    }

    protected function getOptions()
    {
        return [
            ['ready', null, InputOption::VALUE_NONE, 'Indicates that the installer should use an existing .env file.'],
        ];
    }
}
