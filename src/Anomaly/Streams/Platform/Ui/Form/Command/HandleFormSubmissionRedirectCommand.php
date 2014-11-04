<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class HandleFormSubmissionRedirectCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionRedirectCommand
{

    /**
     * The form object.
     *
     * @var
     */
    protected $form;

    /**
     * Create a new HandleFormSubmissionRedirectCommand instance.
     *
     * @param $form
     */
    function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Ger the form UI object.
     *
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }
}
 