<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterLoader;

class TableBuildListener
{

    /**
     * The filter loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Filter\FilterLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param FilterLoader $loader
     */
    public function __construct(FilterLoader $loader)
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
