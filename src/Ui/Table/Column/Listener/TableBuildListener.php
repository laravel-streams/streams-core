<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Listener;

use Anomaly\Streams\Platform\Ui\Table\Column\ColumnLoader;
use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column\Listener
 */
class TableBuildListener
{

    /**
     * The column loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Column\ColumnLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param ColumnLoader $loader
     */
    public function __construct(ColumnLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * When the table is building we want to build and push
     * the columns onto the table's column collection.
     *
     * @param TableBuildEvent $event
     */
    public function handle(TableBuildEvent $event)
    {
        $this->loader->load($event->getBuilder());
    }
}
