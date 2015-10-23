<?php namespace Anomaly\Streams\Platform\View\Listener;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\View\Event\TemplateDataIsLoading;

/**
 * Class LoadGlobalData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Listener
 */
class LoadGlobalData
{

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * Create a new LoadGlobalData instance.
     *
     * @param AddonCollection $addons
     */
    public function __construct(AddonCollection $addons)
    {
        $this->addons = $addons;
    }

    /**
     * Handle the event.
     *
     * @param TemplateDataIsLoading $event
     */
    public function handle(TemplateDataIsLoading $event)
    {
        $template = $event->getTemplate();

        $template->set('addons', $this->addons);
    }
}
