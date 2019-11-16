<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\Console\Command\MakeAddonMigrationPaths;
use Anomaly\Streams\Platform\Addon\Console\Command\ScaffoldTheme;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonButtonLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonClass;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonComposer;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonFeatureTest;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonFieldLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonGitIgnore;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonPackage;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonPermissionLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonPermissions;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonPhpUnit;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonSectionLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonServiceProvider;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonStreamLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonWebpack;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteThemePackage;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteThemeWebpack;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeAddonMigration
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MakeAddonMigration extends Command
{

    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:addon_migration {addon} {name} {--fields}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new addon.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        [$vendor, $type, $slug] = addon_map($addon = $this->argument('addon'));
        dd('Migration');
        $path = $this->dispatchNow(new MakeAddonMigrationPaths($vendor, $type, $slug, $this));

        $this->dispatchNow(new WriteAddonLang($path, $type, $slug));
        $this->dispatchNow(new WriteAddonClass($path, $type, $slug, $vendor));
        $this->dispatchNow(new WriteAddonPhpUnit($path, $type, $slug, $vendor));
        $this->dispatchNow(new WriteAddonComposer($path, $type, $slug, $vendor));
        // @todo Autoloading issues...
        //$this->dispatchNow(new WriteAddonTestCase($path, $type, $slug, $vendor));
        $this->dispatchNow(new WriteAddonGitIgnore($path, $type, $slug, $vendor));
        $this->dispatchNow(new WriteAddonFeatureTest($path, $type, $slug, $vendor));
        $this->dispatchNow(new WriteAddonServiceProvider($path, $type, $slug, $vendor));

        $this->info("Addon [{$vendor}.{$type}.{$slug}] created.");

        /**
         * Create the initial migration file
         * for modules and extensions.
         */
        if (in_array($type, ['module', 'extension']) || $this->option('migration')) {
            $this->call(
                'make:addon_migration',
                [
                    'name'     => 'create_' . $slug . '_fields',
                    '--addon'  => $addon,
                    '--fields' => true,
                ]
            );
        }

        /**
         * Scaffold Modules and Extensions.
         */
        if (in_array($type, ['module', 'extension'])) {
            $this->dispatchNow(new WriteAddonFieldLang($path));
            $this->dispatchNow(new WriteAddonStreamLang($path));
            $this->dispatchNow(new WriteAddonPermissions($path));
            $this->dispatchNow(new WriteAddonPermissionLang($path));
        }

        /**
         * Scaffold Modules.
         */
        if ($type == 'module') {
            $this->dispatchNow(new WriteAddonButtonLang($path));
            $this->dispatchNow(new WriteAddonSectionLang($path));
        }

        /**
         * Scaffold themes.
         *
         * This moves in resources
         * and front-end tooling.
         */
        if ($type == 'theme') {
            $this->dispatchNow(new ScaffoldTheme($path));
            $this->dispatchNow(new WriteThemeWebpack($path));
            $this->dispatchNow(new WriteThemePackage($path));
        }

        /**
         * Scaffold non-themes.
         */
        if ($type !== 'theme') {
            $this->dispatchNow(new WriteAddonWebpack($path));
            $this->dispatchNow(new WriteAddonPackage($path));
        }
    }
}
