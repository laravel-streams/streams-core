<?php

namespace Anomaly\Streams\Platform\Ui\Form\Event;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class FormWasBuilt.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Event
 */
class FormWasBuilt
{
    /**
     * The form object.
     *
     * @var Form
     */
    protected $form;

    /**
     * Create a FormWasBuilt instance.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Get the form.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
