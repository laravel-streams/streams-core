<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormActionsCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormSectionsCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormRedirectsCommand;

/**
 * Class FormService
 *
 * This class returns prepared data for the FormUi in
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
class FormService
{

    use CommandableTrait;

    /**
     * The form UI object.
     *
     * @var FormUi
     */
    protected $ui;

    /**
     * Create a new FormService instance.
     *
     * @param FormUi $ui
     */
    function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Return the sections data.
     *
     * @return mixed
     */
    public function sections()
    {
        $command = new BuildFormSectionsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the redirects data.
     *
     * @return mixed
     */
    public function redirects()
    {
        $command = new BuildFormRedirectsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the actions data.
     *
     * @return mixed
     */
    public function actions()
    {
        $command = new BuildFormActionsCommand($this->ui);

        return $this->execute($command);
    }
}
 