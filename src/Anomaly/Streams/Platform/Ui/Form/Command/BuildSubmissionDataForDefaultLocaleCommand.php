<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class BuildSubmissionDataForDefaultLocaleCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildSubmissionDataForDefaultLocaleCommand
{

    /**
     * The form object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Form
     */
    protected $form;


    /**
     * Create a new BuildSubmissionDataForDefaultLocaleCommand instance.
     *
     * @param Form $form
     */
    function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @return \Anomaly\Streams\Platform\Ui\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
 