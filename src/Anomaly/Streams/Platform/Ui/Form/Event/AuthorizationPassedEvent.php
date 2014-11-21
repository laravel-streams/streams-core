<?php namespace Anomaly\Streams\Platform\Ui\Form\Event;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class AuthorizationPassedEvent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Event
 */
class AuthorizationPassedEvent
{

    /**
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;

    /**
     * Create a new form event instance.
     *
     * @param Form $form
     */
    function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Get the form UI object.
     *
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }
}
 