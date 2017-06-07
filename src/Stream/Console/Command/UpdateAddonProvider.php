<?php namespace Anomaly\Streams\Platform\Stream\Console\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Stream\Command\GetUninstalledStreams;
use Anomaly\Streams\Platform\Stream\Command\PutIntoFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class UpdateAddonProvider
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class UpdateAddonProvider
{

    use DispatchesJobs;

    /**
     * The entity slug.
     *
     * @var string
     */
    private $slug;

    /**
     * The addon instance.
     *
     * @var Addon
     */
    private $addon;

    /**
     * The entity stream namespace.
     *
     * @var string
     */
    private $namespace;

    /**
     * Create a new UpdateAddonProvider instance.
     *
     * @param Addon  $addon
     * @param string $slug      Stream slug
     * @param string $namespace Stream namespace
     */
    public function __construct(Addon $addon, $slug, $namespace)
    {
        $this->slug      = $slug;
        $this->addon     = $addon;
        $this->namespace = $namespace;
    }

    /**
     * Handle the command.
     *
     * @param Filesystem $filesystem
     */
    public function handle(Filesystem $filesystem)
    {
        // Stream values
        $suffix = ucfirst(camel_case($this->slug));
        $entity = str_singular($suffix);

        // Addon values
        $addon  = $this->addon->getSlug();
        $slug   = ucfirst($addon);
        $type   = ucfirst($this->addon->getType());
        $vendor = ucfirst($this->addon->getVendor());

        $streams = $this->dispatch(new GetUninstalledStreams($this->addon));

        $segment    = (count($streams) > 1) ? "/{$this->slug}" : '';
        $prefix     = "{$vendor}\\{$slug}{$type}";
        $controller = "{$prefix}\\Http\\Controller\\Admin\\{$suffix}Controller";

        $path = $this->addon->getPath("src/{$slug}{$type}ServiceProvider.php");

        // Write uses
        $uses = "use Anomaly\\Streams\\Platform\\Model\\{$slug}\\{$slug}{$suffix}EntryModel;\n";
        $uses .= "use {$prefix}\\{$entity}\\Contract\\{$entity}RepositoryInterface;\n";
        $uses .= "use {$prefix}\\{$entity}\\{$entity}Model;\n";
        $uses .= "use {$prefix}\\{$entity}\\{$entity}Repository;\n";

        $this->dispatch(new PutIntoFile($path, '/use.*;\n/i', $uses));

        // Write bindings
        $this->dispatch(new PutIntoFile(
            $path,
            '/protected \$bindings = \[\]/i',
            "protected \$bindings = [\n    ]",
            true
        ));

        $this->dispatch(new PutIntoFile(
            $path,
            '/protected \$bindings = \[\n/i',
            "        {$slug}{$suffix}EntryModel::class => {$entity}Model::class,\n"
        ));

        // Write singletons
        $this->dispatch(new PutIntoFile(
            $path,
            '/protected \$singletons = \[\]/i',
            "protected \$singletons = [\n    ]",
            true
        ));

        $this->dispatch(new PutIntoFile(
            $path,
            '/protected \$singletons = \[\n/i',
            "        {$entity}RepositoryInterface::class => {$entity}Repository::class,\n"
        ));

        // Write routes
        $routes = "        'admin/{$addon}{$segment}'           => '{$controller}@index',\n";
        $routes .= "        'admin/{$addon}{$segment}/create'    => '{$controller}@create',\n";
        $routes .= "        'admin/{$addon}{$segment}/edit/{id}' => '{$controller}@edit',\n";

        $this->dispatch(new PutIntoFile(
            $path,
            '/protected \$routes = \[\]/i',
            "protected \$routes = [\n    ]",
            true
        ));

        $this->dispatch(new PutIntoFile($path, '/protected \$routes = \[\n/i', $routes));
    }
}
