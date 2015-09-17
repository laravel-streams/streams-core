<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Interface ViewHandlerInterface.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Contract
 */
interface ViewHandlerInterface
{
    /**
     * Handle the view's table modification.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder);
}
