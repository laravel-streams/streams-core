<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Anomaly\Streams\Platform\Ui\Table\View\ViewLoader;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View\Listener
 */
class TableBuildListener
{

    /**
     * The view loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\View\ViewLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param ViewLoader $loader
     */
    public function __construct(ViewLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * When the table is building we want to build and push
     * the views onto the table's view collection.
     *
     * @param TableBuildEvent $event
     */
    public function handle(TableBuildEvent $event)
    {
        $this->loader->load($event->getBuilder());
    }
}
