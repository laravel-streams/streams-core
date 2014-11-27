<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

use Anomaly\Streams\Platform\Ui\Form\Form;

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
     * @param Form $form
     * @return mixed
     */
    public function validate(Form $form);
}
 