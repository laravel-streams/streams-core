<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Contract;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;

/**
 * Interface ViewHandlerInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Contract
 */
interface ViewHandlerInterface
{

    /**
     * Handle the TableQueryEvent hook.
     *
     * @param TableQueryEvent $event
     * @return mixed
     */
    public function onTableQuery(TableQueryEvent $event);

    /**
     * Set the TableQueryEvent handler.
     *
     * @param $handler
     * @return $this
     */
    public function setTableQueryHandler($handler);

    /**
     * Get the TableQueryEvent handler.
     *
     * @return mixed
     */
    public function getTableQueryHandler();
}
