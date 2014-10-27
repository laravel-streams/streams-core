<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableUi;

/**
 * Interface TableActionInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableActionInterface
{

    /**
     * Create a new TableActionInterface instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui);

    /**
     * Handle the table action.
     *
     * @return mixed
     */
    public function handle();

}
 