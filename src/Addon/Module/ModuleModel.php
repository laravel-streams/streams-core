<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class ModuleModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module
 */
class ModuleModel extends EloquentModel implements ModuleInterface
{

    /**
     * Define the table name.
     *
     * @var string
     */
    protected $table = 'addons_modules';

    /**
     * Cache minutes.
     *
     * @var int
     */
    protected $cacheMinutes = 99999;

    /**
     * Disable timestamps for modules.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Find a module by it's namespace or return a new
     * module with the given namespace.
     *
     * @param  $namespace
     * @return ModuleModel
     */
    public function findByNamespaceOrNew($namespace)
    {
        $module = $this->findByNamespace($namespace);

        if ($module instanceof ModuleModel) {
            return $module;
        }

        $module = $this->newInstance();

        $module->namespace = $namespace;

        $module->save();

        return $module;
    }

    /**
     * Find a module by it's namespace.
     *
     * @param  $namespace
     * @return null|ModuleModel
     */
    public function findByNamespace($namespace)
    {
        return $this->where('namespace', $namespace)->first();
    }

    /**
     * Get all enabled module namespaces.
     *
     * @return array
     */
    public function getEnabledNamespaces()
    {
        return $this->where('installed', true)->where('enabled', true)->get()->lists('namespace');
    }

    /**
     * Get all installed module namespaces.
     *
     * @return array
     */
    public function getInstalledNamespaces()
    {
        return $this->where('installed', true)->get()->lists('namespace');
    }

    /**
     * Return a new collection.
     *
     * @param array $items
     * @return EloquentCollection
     */
    public function newCollection(array $items = [])
    {
        return new EloquentCollection($items);
    }
}
