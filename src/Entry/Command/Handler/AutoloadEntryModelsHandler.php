<?php namespace Anomaly\Streams\Platform\Entry\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Composer\Autoload\ClassLoader;
use Illuminate\Container\Container;

/**
 * Class AutoloadEntryModelsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class AutoloadEntryModelsCommandHandler
{

    /**
     * The Composer class loader.
     *
     * @var ClassLoader
     */
    protected $loader;

    /**
     * The application container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new AutoloadEntryModelsCommandHandler instance.
     *
     * @param ClassLoader $loader
     * @param Container   $container
     * @param Application $application
     */
    public function __construct(ClassLoader $loader, Container $container, Application $application)
    {
        $this->loader      = $loader;
        $this->container   = $container;
        $this->application = $application;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->loader->addPsr4(
            'Anomaly\Streams\Platform\Model\\',
            $this->container->make('path.base') . '/storage/models/streams/' . $this->application->getReference()
        );

        $this->loader->register();
    }
}
