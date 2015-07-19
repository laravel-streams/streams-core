<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface ViewQueryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Contract
 */
interface ViewQueryInterface
{

    /**
     * Handle the TableQueryEvent.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function handle(TableBuilder $builder, Builder $query);
}
