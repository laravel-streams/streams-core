<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormAuthorityInterface;

/**
 * Class FormAuthority
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormAuthority implements FormAuthorityInterface
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
