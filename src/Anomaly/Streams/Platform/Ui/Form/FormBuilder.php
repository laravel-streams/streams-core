<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormActionsCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormOptionsCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormRedirectsCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormSectionsCommand;

/**
 * Class FormBuilder
 *
 * This class returns prepared data for the Form in
 * order to send it then to the rendered view.
 *
 * The data coming from here should be as an array
 * preferably and pretty dumb. Stupid views = good views.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormBuilder
{

    use CommandableTrait;

    /**
     * The form object.
     *
     * @var Form
     */
    protected $form;

    /**
     * Create a new FormBuilder instance.
     *
     * @param Form $form
     */
    function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Build the sections data.
     *
     * @return mixed
     */
    public function sections()
    {
        return $this->execute(new BuildFormSectionsCommand($this->form));
    }

    /**
     * Build the redirects data.
     *
     * @return mixed
     */
    public function redirects()
    {
        return $this->execute(new BuildFormRedirectsCommand($this->form));
    }

    /**
     * Build the actions data.
     *
     * @return mixed
     */
    public function actions()
    {
        return $this->execute(new BuildFormActionsCommand($this->form));
    }

    /**
     * Build the options data.
     *
     * @return mixed
     */
    public function options()
    {
        return $this->execute(new BuildFormOptionsCommand($this->form));
    }
}
 