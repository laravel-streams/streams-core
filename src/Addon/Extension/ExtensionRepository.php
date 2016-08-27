<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;

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
     * @param  Extension $extension
     * @return bool
     */
    public function create(Extension $extension)
    {
        $instance = $this->model->newInstance();

        $instance->namespace = $extension->getNamespace();
        $instance->installed = false;
        $instance->enabled   = false;

        return $instance->save();
    }

    /**
     * Delete a extension record.
     *
     * @param  Extension      $extension
     * @return ExtensionModel
     */
    public function delete(Extension $extension)
    {
        if (!$extension = $this->model->findByNamespace($extension->getNamespace())) {
            return false;
        }

        if ($extension) {
            $extension->delete();
        }

        return $extension;
    }

    /**
     * Mark a extension as installed.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function install(Extension $extension)
    {
        if (!$extension = $this->model->findByNamespaceOrNew($extension->getNamespace())) {
            return false;
        }

        $extension->installed = true;
        $extension->enabled   = true;

        return $extension->save();
    }

    /**
     * Mark a extension as uninstalled.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function uninstall(Extension $extension)
    {
        $extension = $this->model->findByNamespace($extension->getNamespace());

        $extension->installed = false;
        $extension->enabled   = false;

        return $extension->save();
    }

    /**
     * Mark a extension as disabled.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function disable(Extension $extension)
    {
        $extension = $this->model->findByNamespace($extension->getNamespace());

        $extension->enabled = false;

        return $extension->save();
    }

    /**
     * Mark a extension as enabled.
     *
     * @param  Extension $extension
     * @return bool
     */
    public function enabled(Extension $extension)
    {
        $extension = $this->model->findByNamespace($extension->getNamespace());

        $extension->enabled = true;

        return $extension->save();
    }
}
