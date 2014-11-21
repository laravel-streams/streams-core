<?php namespace Anomaly\Streams\Platform\Ui\Form\Contract;

/**
 * Interface FormAuthorityInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Contract
 */
interface FormAuthorityInterface
{

    /**
     * Authorize the form request.
     *
     * @return mixed
     */
    public function authorize();
}
 