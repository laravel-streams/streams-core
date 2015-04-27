<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionDefaults
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionDefaults
{

    /**
     * Set the default table actions if needed.
     *
     * @param TableBuilder $builder
     */
    public function defaults(TableBuilder $builder)
    {
        if ($builder->getActions() === []) {
            $builder->setActions(['delete']);
        }
    }
}
