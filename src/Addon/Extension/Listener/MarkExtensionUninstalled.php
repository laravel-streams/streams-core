<?php namespace Anomaly\Streams\Platform\Addon\Extension\Listener;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasUninstalled;

/**
 * Class ExtensionUninstalledListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Listener
 */
class MarkExtensionUninstalled
{

    /**
     * The extension repository.
     *
     * @var \Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface
     */
    protected $extensions;

    /**
     * Create a new ExtensionUninstalledListener instance.
     *
     * @param ExtensionRepositoryInterface $extensions
     */
    public function __construct(ExtensionRepositoryInterface $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * When a extension is physically uninstalled we need
     * to update it's database record as uninstalled too.
     *
     * @param ExtensionWasUninstalled $event
     */
    public function handle(ExtensionWasUninstalled $event)
    {
        $this->extensions->uninstall($event->getExtension());
    }
}
