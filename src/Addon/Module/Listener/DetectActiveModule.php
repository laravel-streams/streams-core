<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * Class DetectActiveModule
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
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
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new DetectActiveModule instance.
     *
     * @param Asset            $asset
     * @param Image            $image
     * @param Request          $request
     * @param ModuleCollection $modules
     * @param Container        $container
     * @param Application      $application
     */
    public function __construct(
        Asset $asset,
        Image $image,
        Request $request,
        ModuleCollection $modules,
        Container $container,
        Application $application
    ) {
        $this->asset       = $asset;
        $this->image       = $image;
        $this->request     = $request;
        $this->modules     = $modules;
        $this->container   = $container;
        $this->application = $application;
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
         * @var Route $route
         */
        if (!$route = $this->request->route()) {
            return;
        }

        /**
         * Pull the addon namespace
         * out of the route action.
         */
        $module = array_get($route->getAction(), 'streams::addon');

        /* @var Module $module */
        if ($module && $module = $this->modules->get($module)) {
            $module->setActive(true);
        }

        if (!$module && $this->request->segment(1) == 'admin' && $module = $this->modules->findBySlug(
                $this->request->segment(2)
            )
        ) {
            $module->setActive(true);
        }

        if (!$module) {
            return;
        }

        $this->container->make('view')->addNamespace(
            'module',
            [
                $this->application->getResourcesPath(
                    "addons/{$module->getVendor()}/{$module->getSlug()}-{$module->getType()}/views/"
                ),
                $module->getPath('resources/views'),
            ]
        );
        $this->container->make('translator')->addNamespace('module', $module->getPath('resources/lang'));

        $this->asset->addPath('module', $module->getPath('resources'));
        $this->image->addPath('module', $module->getPath('resources'));
    }
}
