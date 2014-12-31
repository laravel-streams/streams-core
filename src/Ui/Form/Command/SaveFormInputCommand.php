<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class SaveFormInputCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class SaveFormInputCommand
{

    /**
     * The form object.
     *
     * @var Form
     */
    protected $form;

    /**
     * Create a new LoadFormCommand instance.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Get the form object.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
