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
     * @param Extension $extension
     */
    public function create(Extension $extension)
    {
        $instance = $this->model->newInstance();

        $instance->namespace = $extension->getNamespace();
        $instance->installed = false;
        $instance->enabled   = false;

        $instance->save();
    }

    /**
     * Delete a extension record.
     *
     * @param Extension $extension
     */
    public function delete(Extension $extension)
    {
        $extension = $this->model->findByNamespace($extension->getNamespace());

        if ($extension) {
            $extension->delete();
        }

        return $extension;
    }

    /**
     * Mark a extension as installed.
     *
     * @param Extension $extension
     */
    public function install(Extension $extension)
    {
        $extension = $this->model->findByNamespaceOrNew($extension->getNamespace());

        $extension->installed = true;
        $extension->enabled   = true;

        $extension->save();
    }

    /**
     * Mark a extension as uninstalled.
     *
     * @param Extension $extension
     */
    public function uninstall(Extension $extension)
    {
        $extension = $this->model->findByNamespace($extension->getNamespace());

        $extension->installed = false;
        $extension->enabled   = false;

        $extension->save();
    }
}
