<?php namespace Anomaly\Streams\Platform\Stream\Console\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;

/**
 * Class WriteEntityModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console\Command
 */
class WriteEntityModel implements SelfHandling
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
     * Create a new WriteEntityModel instance.
     *
     * @param Addon $addon
     * @param       $slug
     * @param       $namespace
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
        $suffix = ucfirst(camel_case($this->slug));
        $prefix = ucfirst(camel_case($this->namespace));
        $entity = str_singular($suffix);

        $class      = "{$entity}Model";
        $implements = "{$entity}Interface";
        $extends    = $prefix . $suffix . 'EntryModel';
        $namespace  = $this->addon->getTransformedClass("{$entity}");
        $interface  = $this->addon->getTransformedClass("{$entity}\\Contract\\{$entity}Interface");
        $base       = "Anomaly\\Streams\\Platform\\Model\\{$prefix}\\{$suffix}";

        $path = $this->addon->getPath("src/{$entity}/{$entity}Model.php");

        $template = $filesystem->get(
            base_path("vendor/anomaly/streams-platform/resources/stubs/entity/model.stub")
        );

        $filesystem->makeDirectory(dirname($path), 0755, true, true);

        $filesystem->put(
            $path,
            $parser->parse($template, compact('class', 'extends', 'implements', 'namespace', 'interface', 'base'))
        );
    }
}
