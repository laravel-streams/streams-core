<?php namespace Anomaly\Streams\Platform\Ui\Button\Listener;

use Anomaly\Streams\Platform\Ui\Button\ButtonBuilder;
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
     * The button builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Button\ButtonBuilder
     */
    protected $builder;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param ButtonBuilder $builder
     */
    public function __construct(ButtonBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * When the table is building we want to build and push
     * the views onto the table's view collection.
     *
     * @param TableBuildEvent $event
     */
    public function handle(TableBuildEvent $event)
    {
        $this->builder->build($event->getBuilder());
    }
}
