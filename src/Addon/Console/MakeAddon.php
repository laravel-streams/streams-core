<?php namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\Command\RegisterAddons;
use Anomaly\Streams\Platform\Addon\Console\Command\MakeAddonPaths;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonClass;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonComposer;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonLang;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeAddon
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Console
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
     */
    public function fire()
    {
        $namespace = $this->argument('namespace');

        if (!str_is('*.*.*', $namespace)) {
            throw new \Exception("The namespace should be snake case and formatted like: {vendor}.{type}.{slug}");
        }

        list($vendor, $type, $slug) = array_map(
            function ($value) {
                return snake_case($value);
            },
            explode('.', $namespace)
        );

        $type = str_singular($type);

        $path = $this->dispatch(new MakeAddonPaths($vendor, $type, $slug, $this));

        $this->dispatch(new WriteAddonLang($path, $type, $slug));
        $this->dispatch(new WriteAddonClass($path, $type, $slug, $vendor));
        $this->dispatch(new WriteAddonComposer($path, $type, $slug, $vendor));
        $this->dispatch(new WriteAddonServiceProvider($path, $type, $slug, $vendor));

        $this->dispatch(new RegisterAddons());

        if ($type == 'module' || $this->option('migration')) {
            $this->call(
                'make:migration',
                [
                    'name'     => 'create_' . $slug . '_fields',
                    '--addon'  => "{$vendor}.{$type}.{$slug}",
                    '--fields' => true
                ]
            );
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
            ['namespace', InputArgument::REQUIRED, 'The addon\'s desired dot namespace.']
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
            ['migration', null, InputOption::VALUE_NONE, 'Indicates if a fields migration should be created.']
        ];
    }
}
