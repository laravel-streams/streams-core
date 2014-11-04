<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormActionsCommand;
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
     * The form UI object.
     *
     * @var Form
     */
    protected $ui;

    /**
     * Create a new FormBuilder instance.
     *
     * @param Form $ui
     */
    function __construct(Form $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Build the sections data.
     *
     * @return mixed
     */
    public function sections()
    {
        $command = new BuildFormSectionsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Build the redirects data.
     *
     * @return mixed
     */
    public function redirects()
    {
        $command = new BuildFormRedirectsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Build the actions data.
     *
     * @return mixed
     */
    public function actions()
    {
        $command = new BuildFormActionsCommand($this->ui);

        return $this->execute($command);
    }
}
 