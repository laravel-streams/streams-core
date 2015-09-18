<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Interface ActionHandlerInterface.
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
     * @param TableBuilder $builder
     * @param array        $selected
     * @return mixed
     */
    public function handle(TableBuilder $builder, array $selected);
}
