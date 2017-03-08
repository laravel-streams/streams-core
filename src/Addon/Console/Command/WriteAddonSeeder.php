<?php namespace Anomaly\Streams\Platform\Addon\Console\Command;

use Illuminate\Filesystem\Filesystem;
use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Stream\StreamCollection;

/**
 * Class WriteAddonSeeder
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @link   http://pyrocms.com/
 */
class WriteAddonSeeder
{

    /**
     * The addon path.
     *
     * @var string
     */
    private $path;

    /**
     * The addon type.
     *
     * @var string
     */
    private $type;

    /**
     * The addon slug.
     *
     * @var string
     */
    private $slug;

    /**
     * The vendor slug.
     *
     * @var string
     */
    private $vendor;

    /**
     * Create a new WriteAddonSeeder instance.
     *
     * @param string           $path    The path
     * @param string           $type    The type
     * @param string           $slug    The slug
     * @param string           $vendor  The vendor
     * @param StreamCollection $streams The streams
     */
    public function __construct($path, $type, $slug, $vendor, StreamCollection $streams)
    {
        $this->path    = $path;
        $this->slug    = $slug;
        $this->type    = $type;
        $this->vendor  = $vendor;
        $this->streams = $streams;
    }

    /**
     * Handle the command.
     *
     * @param Parser     $parser
     * @param Filesystem $filesystem
     */
    public function handle(Parser $parser, Filesystem $filesystem)
    {
        $slug   = ucfirst(camel_case($this->slug));
        $type   = ucfirst(camel_case($this->type));
        $vendor = ucfirst(camel_case($this->vendor));

        $addon     = $slug.$type;
        $class     = $addon.'Seeder';
        $namespace = "{$vendor}\\{$addon}";
        $uses      = $this->getUses($namespace)->implode("\n");
        $calls     = $this->getCalls()->implode("\n        ");

        $path = "{$this->path}/src/{$class}.php";

        $template = $filesystem->get(
            base_path('vendor/anomaly/streams-platform/resources/stubs/addons/seeder.stub')
        );

        $filesystem->makeDirectory(dirname($path), 0755, true, true);

        $filesystem->put($path, $parser->parse(
            $template,
            compact('namespace', 'class', 'uses', 'calls')
        ));
    }

    /**
     * Gets the uses.
     *
     * @param  string     $namespace The namespace
     * @return Collection The uses.
     */
    public function getUses($namespace)
    {
        return $this->streams->map(
            function ($stream) use ($namespace)
            {
                $name = ucfirst(str_singular($stream->getSlug()));

                return "use {$namespace}\\{$name}\\{$name}Seeder;";
            }
        );
    }

    /**
     * Gets the calls.
     *
     * @return Collection The calls.
     */
    public function getCalls()
    {
        return $this->streams->map(
            function ($stream)
            {
                $name = ucfirst(str_singular($stream->getSlug()));

                return "\$this->call({$name}Seeder::class);";
            }
        );
    }

    /**
     * Gets the name.
     *
     * @param  string $slug The slug
     * @return string The name.
     */
    public function getName($slug)
    {
        return ucfirst(str_singular($slug));
    }
}
