<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Support\Configurator;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Translation\Translator;
use Twig_ExtensionInterface;

class AddonIntegrator
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
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * The configurator utility.
     *
     * @var Configurator
     */
    protected $configurator;

    /**
     * Create a new AddonIntegrator instance.
     *
     * @param Factory $views
     * @param Dispatcher $events
     * @param Container $container
     * @param Translator $translator
     * @param AddonProvider $provider
     * @param Application $application
     * @param Configurator $configurator
     * @param AddonCollection $collection
     * @internal param Asset $asset
     * @internal param Image $image
     */
    public function __construct(
        Factory $views,
        Dispatcher $events,
        Container $container,
        Translator $translator,
        AddonProvider $provider,
        Application $application,
        Configurator $configurator,
        AddonCollection $collection
    ) {
        $this->views        = $views;
        $this->events       = $events;
        $this->provider     = $provider;
        $this->container    = $container;
        $this->collection   = $collection;
        $this->translator   = $translator;
        $this->application  = $application;
        $this->configurator = $configurator;
    }

    /**
     * Register an addon.
     *
     * @param         $path
     * @param         $namespace
     * @param boolean $enabled
     * @param boolean $installed
     * @return Addon|Extension|Module|Twig_ExtensionInterface
     */
    public function register($path, $namespace, $enabled, $installed)
    {
        if (!is_dir($path)) {
            return null;
        }

        list($vendor, $type, $slug) = explode('.', $namespace);

        $class = studly_case($vendor) . '\\' . studly_case($slug) . studly_case($type) . '\\' . studly_case(
                $slug
            ) . studly_case($type);

        /* @var Addon|Module|Extension|Twig_ExtensionInterface $addon */
        $addon = app($class)
            ->setPath($path)
            ->setType($type)
            ->setSlug($slug)
            ->setVendor($vendor);

        // If the addon supports states - set the state now.
        if ($addon->getType() === 'module' || $addon->getType() === 'extension') {
            $addon->setInstalled($installed);
            $addon->setEnabled($enabled);
        }

        // Bind to the service container.
        $this->container->alias($addon->getNamespace(), $alias = get_class($addon));
        $this->container->instance($alias, $addon);

        // Load package configuration.
        $this->configurator->addNamespace($addon->getNamespace(), $addon->getPath('resources/config'));

        // Load system overrides.
        $this->configurator->addNamespaceOverrides(
            $addon->getNamespace(),
            base_path(
                'resources/addons/'
                . $addon->getVendor() . '/'
                . $addon->getSlug() . '-'
                . $addon->getType()
            )
        );

        // Load application overrides.
        $this->configurator->addNamespaceOverrides(
            $addon->getNamespace(),
            $this->application->getResourcesPath(
                'addons/'
                . $addon->getVendor() . '/'
                . $addon->getSlug() . '-'
                . $addon->getType()
                . '/config'
            )
        );

        // Continue loading things.
        $this->provider->register($addon);

        // Add the view / translation namespaces.
        $this->views->addNamespace(
            $addon->getNamespace(),
            [
                $this->application->getResourcesPath(
                    "addons/{$addon->getVendor()}/{$addon->getSlug()}-{$addon->getType()}/views/"
                ),
                $addon->getPath('resources/views'),
            ]
        );
        $this->translator->addNamespace($addon->getNamespace(), $addon->getPath('resources/lang'));
        
        /*
         * If the addon is a plugin then
         * load it into Twig when appropriate.
         */
        if ($addon->getType() === 'plugin') {
            $this->events->listen(
                'Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins',
                function (RegisteringTwigPlugins $event) use ($addon) {

                    $twig = $event->getTwig();

                    if ($twig->hasExtension(get_class($addon))) {
                        return;
                    }

                    $twig->addExtension($addon);
                }
            );
        }

        $this->collection->put($addon->getNamespace(), $addon);

        $this->events->fire(new AddonWasRegistered($addon));

        return $addon;
    }

    /**
     * Finish up addon integration.
     */
    public function finish()
    {
        $this->provider->boot();
    }
}
