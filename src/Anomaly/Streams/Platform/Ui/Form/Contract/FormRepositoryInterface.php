<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

/**
 * Interface FormRepositoryInterface
 *
 * This interface enforces getting / storing form entry data.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormRepositoryInterface
{

    /**
     * @return mixed
     */
    public function get();

    /**
     * @return mixed
     */
    public function store();

}
 