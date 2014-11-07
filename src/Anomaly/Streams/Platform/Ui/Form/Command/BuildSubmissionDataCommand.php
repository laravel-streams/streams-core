<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

class BuildSubmissionDataCommand
{

    /**
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;

    /**
     * Create a new BuildSubmissionDataCommand instance.
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
     * @return \Anomaly\Streams\Platform\Ui\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
 