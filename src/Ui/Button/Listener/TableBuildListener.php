<?php namespace Anomaly\Streams\Platform\Ui\Button\Listener;

use Anomaly\Streams\Platform\Ui\Button\ButtonLoader;
use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button\Listener
 */
class TableBuildListener
{

    /**
     * The button loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Button\ButtonLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param ButtonLoader $loader
     */
    public function __construct(ButtonLoader $loader)
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
