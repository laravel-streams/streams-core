<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Interface ActionHandlerInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract
 */
interface ActionHandlerInterface
{

    /**
     * Handle the action.
     *
     * @param Table $table
     */
    public function handle(Table $table);
}
