<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;

/**
 * Interface FilterHandlerInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract
 */
interface FilterHandlerInterface
{

    /**
     * Handle the TableQueryEvent.
     *
     * @param TableQueryEvent $event
     */
    public function onTableQuery(TableQueryEvent $event);
}
