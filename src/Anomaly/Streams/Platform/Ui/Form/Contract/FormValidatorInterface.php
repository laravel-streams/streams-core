<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

/**
 * Interface FormValidatorInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormValidatorInterface
{

    /**
     * Validate the form request.
     *
     * @return mixed
     */
    public function validate();
}
 