<?php namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonLoader;
use Anomaly\Streams\Platform\Addon\AddonManager;
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
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeAddon
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MakeAddon extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:addon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new addon.';

    /**
     * Execute the console command.
     *
     * @param AddonManager $addons
     * @param AddonLoader $loader
     * @param Repository $config
     * @throws \Exception
     */
    public function handle(AddonManager $addons, AddonLoader $loader, Repository $config)
    {
        $namespace = $this->argument('namespace');

        if (preg_match('/^\w+\.[a-zA-Z_]+\.\w+\z/u', $namespace) !== 1) {
            throw new \Exception('The namespace should be snake case and formatted like: {vendor}.{type}.{slug}');
        }

        list($vendor, $type, $slug) = array_map(
            function ($value) {
                return str_slug(strtolower($value), '_');
            },
            explode('.', $namespace)
        );

        if (!in_array($type, $config->get('streams::addons.types'))) {
            throw new \Exception("The [{$type}] addon type is invalid.");
        }

        $type = str_singular($type);

        $path = dispatch_sync(new MakeAddonPaths($vendor, $type, $slug, $this));

        dispatch_sync(new WriteAddonLang($path, $type, $slug));
        dispatch_sync(new WriteAddonClass($path, $type, $slug, $vendor));
        dispatch_sync(new WriteAddonPhpUnit($path, $type, $slug, $vendor));
        dispatch_sync(new WriteAddonComposer($path, $type, $slug, $vendor));
        // @todo Autoloading issues...
        //dispatch_sync(new WriteAddonTestCase($path, $type, $slug, $vendor));
        dispatch_sync(new WriteAddonGitIgnore($path, $type, $slug, $vendor));
        dispatch_sync(new WriteAddonFeatureTest($path, $type, $slug, $vendor));
        dispatch_sync(new WriteAddonServiceProvider($path, $type, $slug, $vendor));

        $this->info("Addon [{$vendor}.{$type}.{$slug}] created.");

        $loader
            ->load($path)
            ->register()
            ->dump();

        $addons->register();

        /**
         * Create the initial migration file
         * for modules and extensions.
         */
        if (in_array($type, ['module', 'extension']) || $this->option('migration')) {
            $this->call(
                'make:migration',
                [
                    'name'     => 'create_' . $slug . '_fields',
                    '--addon'  => $namespace,
                    '--fields' => true,
                ]
            );
        }

        /**
         * Scaffold Modules and Extensions.
         */
        if (in_array($type, ['module', 'extension'])) {
            dispatch_sync(new WriteAddonFieldLang($path));
            dispatch_sync(new WriteAddonStreamLang($path));
            dispatch_sync(new WriteAddonPermissions($path));
            dispatch_sync(new WriteAddonPermissionLang($path));
        }

        /**
         * Scaffold Modules.
         */
        if ($type == 'module') {
            dispatch_sync(new WriteAddonButtonLang($path));
            dispatch_sync(new WriteAddonSectionLang($path));
        }

        /**
         * Scaffold themes.
         *
         * This moves in resources
         * and front-end tooling.
         */
        if ($type == 'theme') {
            dispatch_sync(new ScaffoldTheme($path));
            dispatch_sync(new WriteThemeWebpack($path));
            dispatch_sync(new WriteThemePackage($path));
        }

        /**
         * Scaffold non-themes.
         */
        if ($type !== 'theme') {
            dispatch_sync(new WriteAddonWebpack($path));
            dispatch_sync(new WriteAddonPackage($path));
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['namespace', InputArgument::REQUIRED, 'The addon\'s desired dot namespace.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['shared', null, InputOption::VALUE_NONE, 'Indicates if the addon should be created in shared addons.'],
            ['migration', null, InputOption::VALUE_NONE, 'Indicates if a fields migration should be created.'],
        ];
    }
}
