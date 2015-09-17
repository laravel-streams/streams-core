<?php

namespace Anomaly\Streams\Platform\Addon\Console\Command;

use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;

/**
 * Class WriteAddonComposer.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Console\Command
 */
class WriteAddonComposer implements SelfHandling
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
     * Create a new WriteAddonComposer instance.
     *
     * @param $path
     * @param $type
     * @param $slug
     * @param $vendor
     */
    public function __construct($path, $type, $slug, $vendor)
    {
        $this->path   = $path;
        $this->slug   = $slug;
        $this->type   = $type;
        $this->vendor = $vendor;
    }

    /**
     * Handle the command.
     *
     * @param Parser     $parser
     * @param Filesystem $filesystem
     */
    public function handle(Parser $parser, Filesystem $filesystem)
    {
        $path = "{$this->path}/composer.json";

        $slug   = $this->slug;
        $type   = $this->type;
        $vendor = $this->vendor;

        $prefix = ucfirst(camel_case($vendor)).'\\\\'.ucfirst(camel_case($slug)).ucfirst(
                camel_case($type)
            ).'\\\\';

        $template = $filesystem->get(
            base_path('vendor/anomaly/streams-platform/resources/stubs/addons/composer.stub')
        );

        $filesystem->makeDirectory(dirname($path), 0755, true, true);

        $filesystem->put($path, $parser->parse($template, compact('vendor', 'slug', 'type', 'prefix')));
    }
}
