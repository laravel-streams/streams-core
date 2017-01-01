<?php namespace Anomaly\Streams\Platform\Stream\Console\Command;

use Illuminate\Filesystem\Filesystem;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Support\Parser;

/**
 * Class WriteEntitySeeder
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @link   http://pyrocms.com/
 */
class WriteEntitySeeder
{

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
     * Create a new WriteEntitySeeder instance.
     *
     * @param Addon        $addon
     * @param $slug
     * @param $namespace
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
     * @param Parser     $parser
     * @param Filesystem $filesystem
     */
    public function handle(Parser $parser, Filesystem $filesystem)
    {
        $entities = camel_case($this->slug);
        $suffix   = ucfirst($entities);
        $entity   = str_singular($suffix);

        $class     = "{$entity}Seeder";
        $namespace = $this->addon->getTransformedClass("{$entity}");

        $path = $this->addon->getPath("src/{$entity}/{$entity}Seeder.php");

        $template = $filesystem->get(
            base_path('vendor/anomaly/streams-platform/resources/stubs/entity/seeder.stub')
        );

        $filesystem->makeDirectory(dirname($path), 0755, true, true);

        $filesystem->put($path, $parser->parse(
            $template,
            compact('class', 'namespace', 'entity', 'entities')));
    }
}
