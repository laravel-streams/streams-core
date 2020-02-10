<?php

namespace Anomaly\Streams\Platform\Installer\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Anomaly\Streams\Platform\Support\Env;
use Anomaly\Streams\Platform\Support\Collection;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Installer\Installer;
use Anomaly\Streams\Platform\Installer\InstallerCollection;
use Anomaly\Streams\Platform\Installer\Console\Command\SetAdminData;
use Anomaly\Streams\Platform\Installer\Console\Command\SetOtherData;
use Anomaly\Streams\Platform\Installer\Console\Command\RunInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadBaseSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\SetDatabaseData;
use Anomaly\Streams\Platform\Installer\Console\Command\ConfigureDatabase;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadBaseMigrations;
use Anomaly\Streams\Platform\Installer\Console\Command\SetApplicationData;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\loadCoreInstallers;

/**
 * Class Install
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Install extends Command
{

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
    public function handle()
    {
        $this->info('
._____________._.______  ._______.______  ._____.___ .________
|    ___/\__ _:|: __   \ : .____/:      \ :         ||    ___/
|___    \  |  :||  \____|| : _/\ |   .   ||   \  /  ||___    \
|       /  |   ||   :  \ |   /  \|   :   ||   |\/   ||       /
|__:___/   |   ||   |___\|_.: __/|___|   ||___| |   ||__:___/ 
   :       |___||___|       :/       |___|      |___|   :     
                                                              
                  Welcome to the Jungle.                                         
                                                              
            ');

        if (!$this->option('ready')) {
            $this->confirmConfig();
        }

        $installers = new InstallerCollection();

        $this->loadCoreInstallers($installers);
        $this->loadAddonInstallers($installers);

        $installers->push(
            new Installer(
                'anomaly.module.installer::install.reloading_application',
                function () {
                    $this->call('env:set', ['line' => 'INSTALLED=true']);

                    Env::load();
                }
            )
        );

        dispatch_now(new LoadModuleSeeders($installers));
        dispatch_now(new LoadExtensionSeeders($installers));
        dispatch_now(new LoadBaseSeeders($installers));

        $installers->push(
            new Installer(
                'anomaly.module.installer::install.publishing_assets',
                function (Kernel $console) {
                    $console->call('assets:publish');
                }
            )
        );

        dispatch_now(new RunInstallers($installers, $this));
    }

    protected function loadCoreInstallers(InstallerCollection $installers)
    {
        $installers->push(
            new Installer(
                'anomaly.module.installer::install.running_core_migrations',
                function (Kernel $console) {
                    $console->call(
                        'migrate',
                        [
                            '--force' => true,
                            '--path'  => 'vendor/anomaly/streams-platform/migrations',
                        ]
                    );
                }
            )
        );
    }

    protected function loadAddonInstallers(InstallerCollection $installers)
    {
        foreach (app('addon.collection')->installable() as $namespace => $addon) {
            $installers->push(
                new Installer(
                    trans('anomaly.module.installer::install.installing', ['installing' => $addon['name']]),
                    function (Kernel $console) use ($namespace) {
                        $console->call(
                            'addon:install',
                            [
                                'addon' => $namespace,
                            ]
                        );
                    }
                )
            );
        }
    }

    protected function loadAddonSeeders(InstallerCollection $installers)
    {
        foreach (app('addon.collection')->installable() as $namespace => $addon) {
            $installers->push(
                new Installer(
                    trans('anomaly.module.installer::install.seeding', ['seeding' => $addon['name']]),
                    function (Kernel $console) use ($namespace) {
                        $console->call(
                            'addon:seed',
                            [
                                'addon' => $namespace,
                            ]
                        );
                    }
                )
            );
        }
    }

    /**
     * Check if ready to install.
     */
    protected function confirmConfig()
    {
        $data = Env::variables();

        foreach (['APP_', 'ADMIN_', 'DB_'] as $prefix) {

            echo "\n";

            array_walk($data, function ($value, $key) use ($prefix) {
                if (starts_with($key, $prefix)) {
                    echo "{$key}={$value}\n";
                }
            });
        }

        if (!$this->confirm('Does this look right to you?')) {

            $this->error('Good call. Better get that checked out.');

            exit;
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['ready', null, InputOption::VALUE_NONE, 'Skip confirmation of important .env variables.'],
        ];
    }
}
