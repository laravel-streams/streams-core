<?php namespace Anomaly\Streams\Platform\Ui\Form\Event;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class FormIsSaving
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Event
 */
class FormIsSaving
{

    /**
     * The form object.
     *
     * @var Form
     */
    protected $form;

    /**
     * Create a new FormIsSaving instance.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Ge the form.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
