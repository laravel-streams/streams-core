<?php namespace Anomaly\Streams\Platform\Addon\Console\Command;

use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;

/**
 * Class WriteAddonLang
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Console\Command
 */
class WriteAddonLang implements SelfHandling
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
     * Create a new WriteAddonLang instance.
     *
     * @param $path
     * @param $type
     * @param $slug
     */
    public function __construct($path, $type, $slug)
    {
        $this->path = $path;
        $this->slug = $slug;
        $this->type = $type;
    }

    /**
     * Handle the command.
     *
     * @param Parser     $parser
     * @param Filesystem $filesystem
     */
    public function handle(Parser $parser, Filesystem $filesystem)
    {
        $path = "{$this->path}/resources/lang/en/addon.php";

        $title = ucwords(str_replace('_', ' ', $this->slug));
        $type  = ucwords(str_replace('_', ' ', $this->type));

        $template = $filesystem->get(
            base_path('vendor/anomaly/streams-platform/resources/stubs/addons/resources/lang/en/addon.stub')
        );

        $filesystem->makeDirectory(dirname($path), 0755, true, true);
        
        $filesystem->put($path, $parser->parse($template, compact('title', 'type')));
    }
}
