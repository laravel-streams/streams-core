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
     * @param  $slug
     * @return mixed
     */
    public function create($slug)
    {
        $extension = $this->model->newInstance();

        $extension->slug      = $slug;
        $extension->enabled   = false;
        $extension->installed = false;

        $extension->save();

        return $extension;
    }

    /**
     * Delete a extension record.
     *
     * @param  $slug
     * @return mixed
     */
    public function delete($slug)
    {
        $extension = $this->model->findBySlug($slug);

        if ($extension) {

            $extension->delete();
        }

        return $extension;
    }

    /**
     * Mark a extension as installed.
     *
     * @param  $slug
     * @return mixed
     */
    public function install($slug)
    {
        $extension = $this->model->findBySlugOrNew($slug);

        $extension->installed = true;
        $extension->enabled   = true;

        $extension->save();
    }

    /**
     * Mark a extension as uninstalled.
     *
     * @param  $slug
     * @return mixed
     */
    public function uninstall($slug)
    {
        $extension = $this->model->findBySlug($slug);

        $extension->installed = false;
        $extension->enabled   = false;

        $extension->save();
    }
}
