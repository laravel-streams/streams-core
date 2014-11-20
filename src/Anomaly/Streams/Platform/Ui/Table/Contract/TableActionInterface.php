<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

/**
 * Interface TableActionInterface
 *
 * This interface helps assure that table action
 * handlers can at least handle the action.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableActionInterface
{

    /**
     * Handle the table action.
     *
     * @param array $ids
     * @return mixed
     */
    public function handle(array $ids);

    /**
     * Authorize the user to process the action.
     *
     * @return bool
     */
    public function authorize();
}
 