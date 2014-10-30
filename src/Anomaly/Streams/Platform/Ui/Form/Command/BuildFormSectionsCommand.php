<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;

/**
 * Class BuildFormSectionsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionsCommand
{

    /**
     * The form UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUi
     */
    protected $ui;

    /**
     * Create a new BuildFormSectionsCommand instance.
     *
     * @param FormUi $ui
     */
    function __construct(FormUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Get the form UI object.
     *
     * @return FormUi
     */
    public function getUi()
    {
        return $this->ui;
    }

}
 