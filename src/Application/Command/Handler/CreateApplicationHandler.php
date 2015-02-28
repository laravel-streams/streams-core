<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Application\ApplicationRepository;
use Anomaly\Streams\Platform\Application\Command\CreateApplication;

/**
 * Class CreateApplicationHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command\Handler
 */
class CreateApplicationHandler
{

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * The application repository.
     *
     * @var ApplicationRepository
     */
    protected $applications;

    /**
     * Create a new CreateApplicationHandler instance.
     *
     * @param Application           $application
     * @param ApplicationRepository $applications
     */
    function __construct(Application $application, ApplicationRepository $applications)
    {
        $this->application  = $application;
        $this->applications = $applications;
    }

    /**
     * handle the command.
     *
     * @param CreateApplication $command
     */
    public function handle(CreateApplication $command)
    {
        return $this->applications->create($command->getAttributes());
    }
}
