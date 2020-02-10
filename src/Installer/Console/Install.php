<?php

namespace Anomaly\Streams\Platform\Installer\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Anomaly\Streams\Platform\Support\Env;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Installer\Installer;
use Anomaly\Streams\Platform\Installer\InstallerCollection;
use Anomaly\Streams\Platform\Installer\Console\Command\RunInstallers;

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

        $this->loadAddonSeeders($installers);
        $this->loadBaseSeeders($installers);

        $installers->push(
            new Installer(
                'anomaly.module.installer::install.publishing_assets',
                function (Kernel $console) {
                    $console->call('assets:publish');
                }
            )
        );

        $this->runInstallers($installers);
    }

    /**
     * Load the Streams core installers.
     *
     * @param \Anomaly\Streams\Platform\Installer\InstallerCollection $installers
     */
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

    /**
     * Load the addon installers.
     *
     * @param \Anomaly\Streams\Platform\Installer\InstallerCollection $installers
     */
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

    /**
     * Load the addon seeders.
     *
     * @param \Anomaly\Streams\Platform\Installer\InstallerCollection $installers
     */
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
     * Load the base seeders.
     *
     * @param \Anomaly\Streams\Platform\Installer\InstallerCollection $installers
     */
    protected function loadBaseSeeders(InstallerCollection $installers)
    {
        foreach (app('addon.collection')->installable() as $namespace => $addon) {
            $installers->push(
                new Installer(
                    'streams::installer.running_seeds',
                    function (Kernel $console) {
                        $console->call('db:seed', ['--force' => true]);
                    }
                )
            );
        }
    }

    /**
     * Run the installers.
     *
     * @param \Anomaly\Streams\Platform\Installer\InstallerCollection $installers
     */
    protected function runInstallers(InstallerCollection $installers)
    {
        $step  = 1;
        $total = $installers->count();

        /* @var Installer $installer */
        while ($installer = $installers->shift()) {

            $this->info("{$step}/{$total} " . trans($installer->getMessage()));

            app()->call($installer->getTask());

            $step++;
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
