<?php namespace Anomaly\Streams\Platform\Stream\Console\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;

/**
 * Class WriteEntityController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console\Command
 */
class WriteEntityController implements SelfHandling
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
     * Create a new WriteEntityController instance.
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
        $entity = str_singular($suffix);

        $class        = "{$suffix}Controller";
        $form         = "{$entity}FormBuilder";
        $table        = "{$entity}TableBuilder";
        $formBuilder  = $this->addon->getTransformedClass("{$entity}\\Form\\{$entity}FormBuilder");
        $tableBuilder = $this->addon->getTransformedClass("{$entity}\\Table\\{$entity}TableBuilder");

        $namespace = $this->addon->getTransformedClass("{$entity}\\Http\\Controller\\Admin");

        $path = $this->addon->getPath("src/Http/Controller/Admin/{$suffix}Controller.php");

        $template = $filesystem->get(
            base_path("vendor/anomaly/streams-platform/resources/stubs/entity/controller/admin.stub")
        );

        $filesystem->makeDirectory(dirname($path), 0755, true, true);

        $filesystem->put(
            $path,
            $parser->parse($template, compact('class', 'namespace', 'formBuilder', 'tableBuilder', 'form', 'table'))
        );
    }
}
