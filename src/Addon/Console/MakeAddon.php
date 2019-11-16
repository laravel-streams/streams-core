<?php

namespace Anomaly\MakerExtension\Console;

use Anomaly\MakerExtension\Console\Command\MakeAddonPaths;
use Anomaly\MakerExtension\Console\Command\ScaffoldTheme;
use Anomaly\MakerExtension\Console\Command\WriteAddonButtonLang;
use Anomaly\MakerExtension\Console\Command\WriteAddonClass;
use Anomaly\MakerExtension\Console\Command\WriteAddonComposer;
use Anomaly\MakerExtension\Console\Command\WriteAddonFeatureTest;
use Anomaly\MakerExtension\Console\Command\WriteAddonFieldLang;
use Anomaly\MakerExtension\Console\Command\WriteAddonGitIgnore;
use Anomaly\MakerExtension\Console\Command\WriteAddonLang;
use Anomaly\MakerExtension\Console\Command\WriteAddonPackage;
use Anomaly\MakerExtension\Console\Command\WriteAddonPermissionLang;
use Anomaly\MakerExtension\Console\Command\WriteAddonPermissions;
use Anomaly\MakerExtension\Console\Command\WriteAddonPhpUnit;
use Anomaly\MakerExtension\Console\Command\WriteAddonSectionLang;
use Anomaly\MakerExtension\Console\Command\WriteAddonServiceProvider;
use Anomaly\MakerExtension\Console\Command\WriteAddonStreamLang;
use Anomaly\MakerExtension\Console\Command\WriteAddonWebpack;
use Anomaly\MakerExtension\Console\Command\WriteThemePackage;
use Anomaly\MakerExtension\Console\Command\WriteThemeWebpack;
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
