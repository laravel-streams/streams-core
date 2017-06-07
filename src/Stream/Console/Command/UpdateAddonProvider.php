<?php namespace Anomaly\Streams\Platform\Stream\Console\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Stream\Command\GetUninstalledStreams;
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

        $segment    = (count($streams)) ? "/{$this->slug}" : '';
        $prefix     = "{$vendor}\\{$slug}{$type}";
        $controller = "{$prefix}\\Http\\Controller\\Admin\\{$suffix}Controller";

        $path = $this->addon->getPath("src/{$slug}{$type}ServiceProvider.php");

        // Write uses
        $uses = "use Anomaly\\Streams\\Platform\\Model\\{$slug}\\{$slug}{$suffix}EntryModel;\n";
        $uses .= "use {$prefix}\\{$entity}\\Contract\\{$entity}RepositoryInterface;\n";
        $uses .= "use {$prefix}\\{$entity}\\{$entity}Model;\n";
        $uses .= "use {$prefix}\\{$entity}\\{$entity}Repository;\n";

        $this->putInFile($filesystem, $path, '/use.*;\n/i', $uses);

        // Write bindings
        $this->putInFile(
            $filesystem,
            $path,
            '/protected \$bindings = \[\]/i',
            "protected \$bindings = [\n    ]",
            true
        );

        $this->putInFile(
            $filesystem,
            $path,
            '/protected \$bindings = \[\n/i',
            "        {$slug}{$suffix}EntryModel::class => {$entity}Model::class,\n"
        );

        // Write singletons
        $this->putInFile(
            $filesystem,
            $path,
            '/protected \$singletons = \[\]/i',
            "protected \$singletons = [\n    ]",
            true
        );

        $this->putInFile(
            $filesystem,
            $path,
            '/protected \$singletons = \[\n/i',
            "        {$entity}RepositoryInterface::class => {$entity}Repository::class,\n"
        );

        // Write routes
        $routes = "        'admin/{$addon}{$segment}'           => '{$controller}@index',\n";
        $routes .= "        'admin/{$addon}{$segment}/create'    => '{$controller}@create',\n";
        $routes .= "        'admin/{$addon}{$segment}/edit/{id}' => '{$controller}@edit',\n";

        $this->putInFile(
            $filesystem,
            $path,
            '/protected \$routes = \[\]/i',
            "protected \$routes = [\n    ]",
            true
        );

        $this->putInFile($filesystem, $path, '/protected \$routes = \[\n/i', $routes);
    }

    /**
     * Puts in file.
     *
     * @param  Filesystem $filesystem The filesystem
     * @param  string     $path       The file path
     * @param  string     $pattern    The insert marker
     * @param  string     $text       The text
     * @param  boolean    $replace    The replace flag
     * @return number     Recorded bytes
     */
    private function putInFile(Filesystem $filesystem, $path, $pattern, $text, $replace = false)
    {
        $contents = $filesystem->get($path);

        $new_contents = preg_replace(
            $pattern,
            ($replace) ? $text : '$0' . $text,
            $contents,
            1
        );

        return $filesystem->put($path, $new_contents);
    }
}
