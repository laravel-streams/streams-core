<?php namespace Anomaly\Streams\Platform\Addon\Extension\Event;

use Anomaly\Streams\Platform\Addon\Extension\Extension;

/**
 * Class ExtensionWasRegistered
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension\Event
 */
class ExtensionWasRegistered
{

    /**
     * The extension object.
     *
     * @var Extension
     */
    protected $extension;

    /**
     * Create a new ExtensionWasRegistered instance.
     *
     * @param Extension $extension
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }

    /**
     * Get the extension object.
     *
     * @return Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }
}
