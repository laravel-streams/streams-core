<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class HandleFormSubmissionAuthorization
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionAuthorizationCommand
{

    /**
     * The form object.
     *
     * @var
     */
    protected $form;

    /**
     * Create a new HandleFormSubmissionAuthorization instance.
     *
     * @param Form $form
     */
    function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Get the form object.
     *
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }
}
 