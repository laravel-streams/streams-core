<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Support\Configurator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Translation\Translator;

/**
 * Class AddonIntegrator
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonIntegrator
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
     * The view factory.
     *
     * @var Factory
     */
    protected $views;

    /**
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * The configurator utility.
     *
     * @var Configurator
     */
    protected $configurator;

    /**
     * Create a new AddonIntegrator instance.
     *
     * @param Asset        $asset
     * @param Image        $image
     * @param Factory      $views
     * @param Translator   $translator
     * @param Configurator $configurator
     */
    public function __construct(
        Asset $asset,
        Image $image,
        Factory $views,
        Translator $translator,
        Configurator $configurator
    ) {
        $this->asset        = $asset;
        $this->image        = $image;
        $this->views        = $views;
        $this->translator   = $translator;
        $this->configurator = $configurator;
    }

    /**
     * Register integrations for an addon.
     *
     * @param Addon $addon
     */
    public function register(Addon $addon)
    {
        $this->configurator->addNamespace($addon->getNamespace(), $addon->getPath('resources/config'));
        $this->configurator->mergeNamespace(
            $addon->getNamespace(),
            base_path('config/addon/' . $addon->getSlug() . '-' . $addon->getType())
        );

        $this->views->addNamespace($addon->getNamespace(), $addon->getPath('resources/views'));
        $this->translator->addNamespace($addon->getNamespace(), $addon->getPath('resources/lang'));

        $this->asset->addPath($addon->getNamespace(), $addon->getPath('resources'));
        $this->image->addPath($addon->getNamespace(), $addon->getPath('resources'));
    }
}
