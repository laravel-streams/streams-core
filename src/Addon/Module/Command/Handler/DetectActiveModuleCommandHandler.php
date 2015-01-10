<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;

/**
 * Class DetectActiveModuleCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class DetectActiveModuleCommandHandler
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
     * The loaded modules.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new DetectActiveModuleCommandHandler instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(Asset $asset, Image $image, ModuleCollection $modules)
    {
        $this->asset   = $asset;
        $this->image   = $image;
        $this->modules = $modules;
    }

    /**
     * Detect the active module and setup our
     * environment with it.
     */
    public function handle()
    {
        $module = null;

        /**
         * If we are in the admin the second segment
         * MUST be the active module's slug.
         */
        if (app('request')->segment(1) == 'admin') {
            $module = $this->modules->findBySlug(app('request')->segment(2));
        }

        if ($module instanceof Module) {

            $module->setActive(true);

            app('view')->addNamespace('module', $module->getPath('resources/views'));
            app('translator')->addNamespace('module', $module->getPath('resources/lang'));

            $this->asset->addNamespace('module', $module->getPath('resources'));
            $this->image->addNamespace('module', $module->getPath('resources'));
        }
    }
}
