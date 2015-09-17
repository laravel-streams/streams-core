<?php

namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * Class DetectActiveModule.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class DetectActiveModule
{
    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The loaded modules.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The services container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The breadcrumb collection.
     *
     * @var BreadcrumbCollection
     */
    protected $breadcrumbs;

    /**
     * Create a new DetectActiveModule instance.
     *
     * @param Asset                $asset
     * @param Image                $image
     * @param Request              $request
     * @param ModuleCollection     $modules
     * @param Container            $container
     * @param BreadcrumbCollection $breadcrumbs
     */
    public function __construct(
        Asset $asset,
        Image $image,
        Request $request,
        ModuleCollection $modules,
        Container $container,
        BreadcrumbCollection $breadcrumbs
    ) {
        $this->asset       = $asset;
        $this->image       = $image;
        $this->request     = $request;
        $this->modules     = $modules;
        $this->container   = $container;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Detect the active module and setup our
     * environment with it.
     */
    public function handle()
    {
        /**
         * In order to detect we MUST have a route
         * and we MUST have a namespace in the
         * streams::addon action parameter.
         *
         * @var Route
         */
        $route = $this->request->route();

        /* @var Module $module */
        if ($route && $module = $this->modules->get(array_get($route->getAction(), 'streams::addon'))) {
            $module->setActive(true);
        }

        if (! $module && $this->request->segment(1) == 'admin' && $module = $this->modules->findBySlug(
                $this->request->segment(2)
            )
        ) {
            $module->setActive(true);
        }

        if (! $module) {
            return;
        }

        $this->container->make('view')->addNamespace('module', $module->getPath('resources/views'));
        $this->container->make('translator')->addNamespace('module', $module->getPath('resources/lang'));

        $this->asset->addPath('module', $module->getPath('resources'));
        $this->image->addPath('module', $module->getPath('resources'));

        if ($this->request->segment(1) === 'admin') {
            $this->breadcrumbs->add(
                trans($module->getName()),
                url('admin/'.$module->getSlug())
            );
        }
    }
}
