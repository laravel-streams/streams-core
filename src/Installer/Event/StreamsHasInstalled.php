<?php namespace Anomaly\Streams\Platform\Installer\Event;

use Anomaly\Streams\Platform\Installer\InstallerCollection;

/**
 * Class InstallingStreams
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Event
 */
class StreamsHasInstalled
{

    /**
     * The installer collection.
     *
     * @var InstallerCollection
     */
    protected $installers;

    /**
     * Create a new StreamsHasInstalled instance.
     *
     * @param InstallerCollection $installers
     */
    public function __construct(InstallerCollection $installers)
    {
        $this->installers = $installers;
    }

    /**
     * Get the installers.
     *
     * @return InstallerCollection
     */
    public function getInstallers()
    {
        return $this->installers;
    }
}
