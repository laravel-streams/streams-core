<?php namespace Anomaly\Streams\Platform\Ui\Form;

/**
 * Class FormAuthority
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormAuthority
{

    /**
     * Authorize the form request.
     *
     * @param array $input
     */
    public function authorize()
    {
        return true;
    }
}
