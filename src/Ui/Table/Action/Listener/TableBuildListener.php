<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Listener;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionLoader;
use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Listener
 */
class TableBuildListener
{

    /**
     * The action loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Action\ActionLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param ActionLoader $loader
     */
    public function __construct(ActionLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * When the table is building we want to build and push
     * the actions onto the table's action collection.
     *
     * @param TableBuildEvent $event
     */
    public function handle(TableBuildEvent $event)
    {
        $this->loader->load($event->getBuilder());
    }
}
