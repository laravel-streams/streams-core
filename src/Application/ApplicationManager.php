<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Application\Command\CreateApplication;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ApplicationManager
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationManager
{

    use DispatchesJobs;

    /**
     * Create a new application.
     *
     * @param array $attributes
     * @return ApplicationModel
     */
    public function create(array $attributes)
    {
        return $this->dispatch(new CreateApplication($attributes));
    }
}
