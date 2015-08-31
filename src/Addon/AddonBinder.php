<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Support\Configurator;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Translation\Translator;

/**
 * Class AddonBinder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonBinder
{

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $views;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The addon provider.
     *
     * @var AddonProvider
     */
    protected $provider;

    /**
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $collection;

    /**
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * The addon configuration utility.
     *
     * @var AddonConfiguration
     */
    protected $configuration;

    /**
     * Create a new AddonBinder instance.
     *
     * @param Asset              $asset
     * @param Image              $image
     * @param Factory            $views
     * @param Dispatcher         $events
     * @param Container          $container
     * @param Translator         $translator
     * @param AddonProvider      $provider
     * @param AddonCollection    $collection
     * @param AddonConfiguration $configuration
     */
    public function __construct(
        Factory $views,
        Dispatcher $events,
        Container $container,
        Translator $translator,
        AddonProvider $provider,
        AddonCollection $collection,
        AddonConfiguration $configuration
    ) {
        $this->views         = $views;
        $this->events        = $events;
        $this->provider      = $provider;
        $this->container     = $container;
        $this->collection    = $collection;
        $this->translator    = $translator;
        $this->configuration = $configuration;
    }

    /**
     * Register an addon.
     *
     * @param $path
     * @param $enabled
     * @param $installed
     */
    public function register($path, array $enabled, array $installed)
    {
        $vendor = strtolower(basename(dirname($path)));
        $slug   = strtolower(substr(basename($path), 0, strpos(basename($path), '-')));
        $type   = strtolower(substr(basename($path), strpos(basename($path), '-') + 1));

        $addon = studly_case($vendor) . '\\' . studly_case($slug) . studly_case($type) . '\\' . studly_case(
                $slug
            ) . studly_case($type);

        /* @var Addon|Module|Extension $addon */
        $addon = app($addon)
            ->setPath($path)
            ->setType($type)
            ->setSlug($slug)
            ->setVendor($vendor);

        // If the addon supports states - set the state now.
        if ($addon->getType() === 'module' || $addon->getType() === 'extension') {
            $addon->setInstalled(in_array($addon->getNamespace(), $installed));
            $addon->setEnabled(in_array($addon->getNamespace(), $enabled));
        }

        $this->container->alias($addon->getNamespace(), $alias = get_class($addon));
        $this->container->instance($alias, $addon);

        /**
         * Load addon configuration before running
         * the addon's service provider so we can
         * use configurable bindings.
         */
        $this->configuration->load($addon);

        // Continue loading things.
        $this->provider->register($addon);

        // Add the view / translation namespaces.
        $this->views->addNamespace($addon->getNamespace(), $addon->getPath('resources/views'));
        $this->translator->addNamespace($addon->getNamespace(), $addon->getPath('resources/lang'));

        /**
         * If the addon is a plugin then
         * load it into Twig when appropriate.
         */
        if ($addon->getType() === 'plugin') {

            $this->events->listen(
                'Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins',
                function (RegisteringTwigPlugins $event) use ($addon) {

                    $twig = $event->getTwig();

                    $twig->addExtension($addon);
                }
            );
        }

        $this->collection->put($addon->getNamespace(), $addon);
    }
}
