<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class HandleFormResponseCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormResponseCommand
{

    /**
     * The form object.
     *
     * @var
     */
    protected $form;

    /**
     * Create a new HandleFormResponseCommand instance.
     *
     * @param $form
     */
    function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Ger the form object.
     *
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }
}
 