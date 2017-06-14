<?php namespace Anomaly\Streams\Platform\Stream\Console\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Stream\Command\PutIntoFile;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class UpdateAddonClass
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class UpdateAddonClass
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
     * Create a new UpdateAddonClass instance.
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
     */
    public function handle()
    {
        // Stream values
        $singular = str_singular($this->slug);

        // Addon values
        $slug   = ucfirst($this->addon->getSlug());
        $type   = ucfirst($this->addon->getType());

        $path = $this->addon->getPath("src/{$slug}{$type}.php");

        $section = "        '{$this->slug}' => [\n";
        $section .= "            'buttons' => [\n";
        $section .= "                'new_{$singular}',\n";
        $section .= "            ],\n";
        $section .= "        ],\n";

        // Write section
        $this->dispatch(new PutIntoFile(
            $path,
            '/protected \$sections = \[\]/i',
            "protected \$sections = [\n    ]",
            true
        ));

        $this->dispatch(new PutIntoFile(
            $path,
            '/protected \$sections = \[(?:.*\],)?\n(?<!    \];)/s',
            $section
        ));
    }
}
