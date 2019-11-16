<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\Console\Command\MakeAddonPaths;
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

/**
 * Class MakeAddon
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MakeAddon extends Command
{

    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:addon {addon} {--shared} {--migration=}';

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

        $path = dispatch_now(new MakeAddonPaths($vendor, $type, $slug, $this));

        dispatch_now(new WriteAddonLang($path, $type, $slug));
        dispatch_now(new WriteAddonClass($path, $type, $slug, $vendor));
        dispatch_now(new WriteAddonPhpUnit($path, $type, $slug, $vendor));
        dispatch_now(new WriteAddonComposer($path, $type, $slug, $vendor));
        // @todo Autoloading issues...
        //->dispatch_now(new WriteAddonTestCase($path, $type, $slug, $vendor));
        dispatch_now(new WriteAddonGitIgnore($path, $type, $slug, $vendor));
        dispatch_now(new WriteAddonFeatureTest($path, $type, $slug, $vendor));
        dispatch_now(new WriteAddonServiceProvider($path, $type, $slug, $vendor));

        $this->info("Addon [{$vendor}.{$type}.{$slug}] created.");

        /**
         * Create the initial migration file
         * for modules and extensions.
         */
        if (in_array($type, ['module', 'extension']) || $this->option('migration')) {
            $this->call(
                'make:addon_migration',
                [
                    'addon'    => $addon,
                    'name'     => 'create_' . $slug . '_fields',
                    '--fields' => true,
                ]
            );
        }

        /**
         * Scaffold Modules and Extensions.
         */
        if (in_array($type, ['module', 'extension'])) {
            dispatch_now(new WriteAddonFieldLang($path));
            dispatch_now(new WriteAddonStreamLang($path));
            dispatch_now(new WriteAddonPermissions($path));
            dispatch_now(new WriteAddonPermissionLang($path));
        }

        /**
         * Scaffold Modules.
         */
        if ($type == 'module') {
            dispatch_now(new WriteAddonButtonLang($path));
            dispatch_now(new WriteAddonSectionLang($path));
        }

        /**
         * Scaffold themes.
         *
         * This moves in resources
         * and front-end tooling.
         */
        if ($type == 'theme') {
            dispatch_now(new ScaffoldTheme($path));
            dispatch_now(new WriteThemeWebpack($path));
            dispatch_now(new WriteThemePackage($path));
        }

        /**
         * Scaffold non-themes.
         */
        if ($type !== 'theme') {
            dispatch_now(new WriteAddonWebpack($path));
            dispatch_now(new WriteAddonPackage($path));
        }
    }
}
