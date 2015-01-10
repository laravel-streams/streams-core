<?php namespace Anomaly\Streams\Platform\Addon\Extension\Listener;

use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasRegistered;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;

/**
 * Class PutExtensionInCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension\Listener
 */
class PutExtensionInCollection
{

    /**
     * The extension collection.
     *
     * @var ExtensionCollection
     */
    protected $extensions;

    /**
     * Create a new PutExtensionInCollection instance.
     *
     * @param ExtensionCollection $extensions
     */
    public function __construct(ExtensionCollection $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * Handle the event.
     *
     * @param ExtensionWasRegistered $event
     */
    public function handle(ExtensionWasRegistered $event)
    {
        $extension = $event->getExtension();

        $this->extensions->put(get_class($extension), $extension);
    }
}
