<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Container\Container;

/**
 * Class LocateApplicationCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class LocateApplicationCommandHandler
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
     * Create a new LocateApplicationCommandHandler instance.
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
        if (file_exists($this->container->make('path.base') . '/config/distribution.php')) {

            $this->application->locate();

            if (file_exists($this->container->make('path.base') . '/config/database.php')) {

                $this->application->setup();
            }
        }
    }
}
