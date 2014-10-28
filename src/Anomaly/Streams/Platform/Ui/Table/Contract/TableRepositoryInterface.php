<?php namespace Anomaly\Streams\Platform\Ui\Table\Contract;

/**
 * Interface TableRepositoryInterface
 *
 * This interface helps assure that the table UI will work
 * interchangeably without direct coupling to Streams
 * or it's models / add-ons.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Contract
 */
interface TableRepositoryInterface
{

    /**
     * Get entry interfaces.
     *
     * @return mixed
     */
    public function get();

}
 