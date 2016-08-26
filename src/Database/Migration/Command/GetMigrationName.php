<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;

class GetMigrationName
{

    /**
     * The migration name.
     *
     * @var string
     */
    protected $name;

    /**
     * The namespace.
     *
     * @var string|null
     */
    protected $namespace = null;

    /**
     * Create a new GetMigrationName instance.
     *
     * @param $name
     * @param $namespace
     */
    public function __construct($name, $namespace = null)
    {
        $this->name      = $name;
        $this->namespace = $namespace;
    }

    /**
     * Handle the command.
     *
     * @param  AddonCollection $addons
     * @return string
     */
    public function handle(AddonCollection $addons)
    {
        $name = $original = $this->name;

        if ($addon = $addons->get($this->namespace)) {
            $name = "{$this->namespace}__{$original}";

            // Append the package version if there is one.
            if ($json = $addon->getComposerJson()) {
                if (property_exists($json, 'version')) {
                    $version = str_slug(str_replace(['.', '-'], '_', $json->version), '_');

                    $name = "{$this->namespace}__{$version}__{$original}";
                }
            }
        }

        return $name;
    }
}
