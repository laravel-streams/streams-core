<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Support\Configurator;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Illuminate\Contracts\Events\Dispatcher;
use Twig_ExtensionInterface;

/**
 * Class AddonIntegrator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonIntegrator
{

    /**
     * The addon provider.
     *
     * @var AddonProvider
     */
    protected $provider;

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $collection;

    /**
     * Create a new AddonIntegrator instance.
     *
     * @param AddonProvider $provider
     * @param AddonCollection $collection
     */
    public function __construct(AddonProvider $provider, AddonCollection $collection)
    {
        $this->provider   = $provider;
        $this->collection = $collection;
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
        app()->alias($addon->getNamespace(), $alias = get_class($addon));
        app()->instance($alias, $addon);

        // Load package configuration.
        if (!file_exists(base_path('bootstrap/cache/config.php'))) {

            if (is_dir($directory = $addon->getPath('resources/config'))) {
                Configurator::load($directory, $addon->getNamespace());
            }

            // Load published overrides.
            if (is_dir(
                $directory = base_path(
                    'resources/addons/'
                        . $addon->getVendor() . '/'
                        . $addon->getSlug() . '-'
                        . $addon->getType()
                        . '/config'
                )
            )) {
                Configurator::merge($directory, $addon->getNamespace());
            }
        }

        // Load application overrides.
        if (is_dir(
            $directory = application()->getResourcesPath(
                'addons/'
                    . $addon->getVendor() . '/'
                    . $addon->getSlug() . '-'
                    . $addon->getType()
                    . '/config'
            )
        )) {
            Configurator::merge($directory, $addon->getNamespace());
        }

        // Continue loading things.
        $this->provider->register($addon);

        // Add the view / translation namespaces.
        view()->addNamespace(
            $addon->getNamespace(),
            [
                application()->getResourcesPath(
                    "addons/{$addon->getVendor()}/{$addon->getSlug()}-{$addon->getType()}/views/"
                ),
                base_path("resources/addons/{$addon->getVendor()}/{$addon->getSlug()}-{$addon->getType()}/views/"),
                $addon->getPath('resources/views'),
            ]
        );
        trans()->addNamespace($addon->getNamespace(), $addon->getPath('resources/lang'));

        /*
         * If the addon is a plugin then
         * load it into Twig when appropriate.
         */
        if ($addon->getType() === 'plugin') {
            app(Dispatcher::class)->listen(
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

        event(new AddonWasRegistered($addon));

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
