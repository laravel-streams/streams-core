<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Container\Container;

/**
 * Class LocateApplicationHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class LocateApplicationHandler
{

    /**
     * The application container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The streams application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new LocateApplicationHandler instance.
     *
     * @param Container   $container
     * @param Application $application
     */
    public function __construct(Container $container, Application $application)
    {
        $this->container   = $container;
        $this->application = $application;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        define('INSTALLED', $this->application->isInstalled());

        if (INSTALLED) {

            $this->application->locate();

            define('APP_REF', $this->application->getReference());

            if (file_exists($this->container->make('path.base') . '/config/database.php')) {

                $this->application->setup();
            }
        }
    }
}
