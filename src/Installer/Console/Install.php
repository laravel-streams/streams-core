<?php

namespace Anomaly\Streams\Platform\Installer\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Anomaly\Streams\Platform\Support\Env;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Entry\EntryLoader;
use Anomaly\Streams\Platform\Support\Collection;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Installer\Installer;
use Anomaly\Streams\Platform\Installer\InstallerCollection;
use Anomaly\Streams\Platform\Installer\Console\Command\SetAdminData;
use Anomaly\Streams\Platform\Installer\Console\Command\SetOtherData;
use Anomaly\Streams\Platform\Installer\Console\Command\RunInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\ConfirmLicense;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadBaseSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\SetDatabaseData;
use Anomaly\Streams\Platform\Installer\Console\Command\ConfigureDatabase;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadBaseMigrations;
use Anomaly\Streams\Platform\Installer\Console\Command\SetApplicationData;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionSeeders;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadModuleInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadExtensionInstallers;
use Anomaly\Streams\Platform\Installer\Console\Command\LoadApplicationInstallers;

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
        $data = new Collection();

        if (!$this->option('ready')) {

            dispatch_now(new ConfirmLicense($this));
            dispatch_now(new SetDatabaseData($data, $this));
            dispatch_now(new SetApplicationData($data, $this));
            dispatch_now(new SetAdminData($data, $this));
            dispatch_now(new SetOtherData($data, $this));

            if (Env::generate()) {
                Env::load();
            }

            Env::save($data->all());

            DB::reconnect();
        }

        Env::load();

        dispatch_now(new ConfigureDatabase());

        $installers = new InstallerCollection();

        dispatch_now(new LoadApplicationInstallers($installers));
        dispatch_now(new LoadModuleInstallers($installers));
        dispatch_now(new LoadExtensionInstallers($installers));

        $installers->push(
            new Installer(
                'streams::installer.reloading_application',
                function () {
                    $this->call('env:set', ['line' => 'INSTALLED=true']);

                    Env::load();
                }
            )
        );

        dispatch_now(new LoadModuleSeeders($installers));
        dispatch_now(new LoadExtensionSeeders($installers));

        dispatch_now(new LoadBaseMigrations($installers));
        dispatch_now(new LoadBaseSeeders($installers));

        dispatch_now(new RunInstallers($installers, $this));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['ready', null, InputOption::VALUE_NONE, 'Indicates that the installer should use an existing .env file.'],
        ];
    }
}
