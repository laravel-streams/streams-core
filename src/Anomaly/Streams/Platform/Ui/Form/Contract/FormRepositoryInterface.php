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
     * Get an entry or return a new one.
     *
     * @return mixed
     */
    public function get();

    /**
     * Store save the entry data from the form.
     *
     * @return mixed
     */
    public function store();
}
 