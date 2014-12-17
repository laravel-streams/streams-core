<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Anomaly\Streams\Platform\Ui\Table\Header\HeaderLoader;

class TableBuildListener
{

    /**
     * The header loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Header\HeaderLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param HeaderLoader $loader
     */
    public function __construct(HeaderLoader $loader)
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
