<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class ExtensionModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionModel extends EloquentModel implements ExtensionInterface
{

    /**
     * Define the table name.
     *
     * @var string
     */
    protected $table = 'addons_extensions';

    /**
     * Cache minutes.
     *
     * @var int
     */
    protected $cacheMinutes = 99999;

    /**
     * Disable timestamps for extensions.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Find a extension by it's namespace or return a new
     * extension with the given namespace.
     *
     * @param  $namespace
     * @return ExtensionModel
     */
    public function findByNamespaceOrNew($namespace)
    {
        $extension = $this->findByNamespace($namespace);

        if ($extension instanceof ExtensionModel) {
            return $extension;
        }

        $extension = $this->newInstance();

        $extension->namespace = $namespace;

        $extension->save();

        return $extension;
    }

    /**
     * Find a extension by it's namespace.
     *
     * @param  $namespace
     * @return mixed
     */
    public function findByNamespace($namespace)
    {
        return $this->where('namespace', $namespace)->first();
    }

    /**
     * Get all enabled extensions.
     *
     * @return EloquentCollection
     */
    public function getEnabled()
    {
        return $this->where('installed', true)->where('enabled', true)->get();
    }
}
