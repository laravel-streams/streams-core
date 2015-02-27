<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;

/**
 * Class ExtensionRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionRepository implements ExtensionRepositoryInterface
{

    /**
     * The extension model.
     *
     * @var
     */
    protected $model;

    /**
     * Create a new ExtensionRepository instance.
     *
     * @param ExtensionModel $model
     */
    public function __construct(ExtensionModel $model)
    {
        $this->model = $model;
    }

    /**
     * Return all extensions in the database.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Create a extension record.
     *
     * @param  $namespace
     * @return mixed
     */
    public function create($namespace)
    {
        $extension = $this->model->newInstance();

        $extension->namespace = $namespace;
        $extension->installed = false;
        $extension->enabled   = false;

        $extension->save();

        return $extension;
    }

    /**
     * Delete a extension record.
     *
     * @param  $namespace
     * @return mixed
     */
    public function delete($namespace)
    {
        $extension = $this->model->findByNamespace($namespace);

        if ($extension) {
            $extension->delete();
        }

        return $extension;
    }

    /**
     * Mark a extension as installed.
     *
     * @param  $namespace
     * @return mixed
     */
    public function install($namespace)
    {
        $extension = $this->model->findByNamespaceOrNew($namespace);

        $extension->installed = true;
        $extension->enabled   = true;

        $extension->save();
    }

    /**
     * Mark a extension as uninstalled.
     *
     * @param  $namespace
     * @return mixed
     */
    public function uninstall($namespace)
    {
        $extension = $this->model->findByNamespace($namespace);

        $extension->installed = false;
        $extension->enabled   = false;

        $extension->save();
    }
}
