<?php namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\Command\RegisterAddons;
use Anomaly\Streams\Platform\Addon\Console\Command\MakeAddonPaths;
use Anomaly\Streams\Platform\Addon\Console\Command\ScaffoldTheme;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonClass;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonComposer;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonFeatureTest;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonGitIgnore;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonPhpUnit;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonServiceProvider;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonTestCase;
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
     * @param Repository   $config
     * @throws \Exception
     */
    public function fire(AddonManager $addons, Repository $config)
    {
        $namespace = $this->argument('namespace');

        if (!str_is('*.*.*', $namespace)) {
            throw new \Exception("The namespace should be snake case and formatted like: {vendor}.{type}.{slug}");
        }

        list($vendor, $type, $slug) = array_map(
            function ($value) {
                return str_slug(strtolower($value), '_');
            },
            explode('.', $namespace)
        );

        if (!in_array($type, $config->get('streams::addons.types'))) {
            throw new \Exception("The [$type] addon type is invalid.");
        }

        $type = str_singular($type);

        $path = $this->dispatch(new MakeAddonPaths($vendor, $type, $slug, $this));

        $this->dispatch(new WriteAddonLang($path, $type, $slug));
        $this->dispatch(new WriteAddonClass($path, $type, $slug, $vendor));
        $this->dispatch(new WriteAddonPhpUnit($path, $type, $slug, $vendor));
        $this->dispatch(new WriteAddonComposer($path, $type, $slug, $vendor));
        // @todo Autoloading issues...
        //$this->dispatch(new WriteAddonTestCase($path, $type, $slug, $vendor));
        $this->dispatch(new WriteAddonGitIgnore($path, $type, $slug, $vendor));
        $this->dispatch(new WriteAddonFeatureTest($path, $type, $slug, $vendor));
        $this->dispatch(new WriteAddonServiceProvider($path, $type, $slug, $vendor));

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
         * Scaffold themes.
         *
         * This moves in Bootstrap 3
         * Font-Awesome and jQuery.
         */
        if ($type == 'theme') {
            $this->dispatch(new ScaffoldTheme($path));
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
