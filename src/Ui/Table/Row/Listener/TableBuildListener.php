<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Listener;

use Anomaly\Streams\Platform\Ui\Table\Event\TableBuildEvent;
use Anomaly\Streams\Platform\Ui\Table\Row\RowLoader;

/**
 * Class TableBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row\Listener
 */
class TableBuildListener
{

    /**
     * The row loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Row\RowLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param RowLoader $loader
     */
    public function __construct(RowLoader $loader)
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
        $builder = $event->getBuilder();
        $table   = $builder->getTable();

        foreach ($table->getEntries() as $entry) {
            $this->loader->load($builder, $entry);
        }
    }
}
