<?php namespace Anomaly\Streams\Platform\Database\Seeder\Console;

use \Illuminate\Support\Composer;
use \Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Anomaly\Streams\Platform\Stream\Command\GetStreams;
use Anomaly\Streams\Platform\Addon\Console\Command\WriteAddonSeeder;
use Anomaly\Streams\Platform\Stream\Console\Command\WriteEntitySeeder;

class SeederMakeCommand extends \Illuminate\Console\Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder class for addon';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @param  \Illuminate\Support\Composer      $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files);

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        /* @var Addon $addon */
        if (!$addon = $this->dispatch(new GetAddon($this->getAddonNamespace())))
        {
            throw new \Exception('Addon could not be found.');
        }

        $path   = $addon->getPath();
        $type   = $addon->getType();
        $slug   = $addon->getSlug();
        $vendor = $addon->getVendor();

        if ($type != 'module' && $type != 'extension')
        {
            throw new \Exception('Only {module} and {extension} addon types are allowed!!!');
        }

        /* @var StreamCollection $streams */
        $streams = $this->getStreams($slug)->each(
            function ($stream) use ($addon)
            {
                $this->dispatch(new WriteEntitySeeder(
                    $addon,
                    $stream->getSlug(),
                    $stream->getNamespace()
                ));
            }
        );

        $this->dispatch(new WriteAddonSeeder($path, $type, $slug, $vendor, $streams));

        $this->composer->dumpAutoloads();

        $this->info($this->type.' created successfully.');
    }

    /**
     * Get the options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['stream', null, InputOption::VALUE_OPTIONAL, 'The stream slug.'],
                ['shared', null, InputOption::VALUE_NONE, 'Indicates if the addon should be created in shared addons.'],
            ]
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['namespace', InputArgument::REQUIRED, 'The namespace of the addon'],
        ];
    }

    /**
     * Gets the stream namespace.
     *
     * @throws \Exception
     * @return string       The stream namespace.
     */
    public function getAddonNamespace()
    {
        $namespace = $this->argument('namespace');

        if (!str_is('*.*.*', $namespace))
        {
            throw new \Exception('The namespace should be snake case and formatted like: {vendor}.{type}.{slug}');
        }

        return $namespace;
    }

    /**
     * Gets the streams.
     *
     * @param  string             $slug The addon slug
     * @return StreamCollection
     */
    public function getStreams($slug)
    {
        return $this->dispatch(new GetStreams($slug))->filter(
            function ($stream)
            {
                return !str_contains($stream->getSlug(), '_');
            }
        );
    }
}
