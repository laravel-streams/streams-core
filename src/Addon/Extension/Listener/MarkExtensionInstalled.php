<?php namespace Anomaly\Streams\Platform\Addon\Extension\Listener;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled;

/**
 * Class ExtensionInstalledListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Listener
 */
class MarkExtensionInstalled
{

    /**
     * The extension repository.
     *
     * @var \Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface
     */
    protected $extensions;

    /**
     * Create a new ExtensionInstalledListener instance.
     *
     * @param ExtensionRepositoryInterface $extensions
     */
    public function __construct(ExtensionRepositoryInterface $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * When a extension is physically installed we need
     * to update it's database record as installed too.
     *
     * @param ExtensionWasInstalled $event
     */
    public function handle(ExtensionWasInstalled $event)
    {
        $this->extensions->install($event->getExtension());
    }
}
