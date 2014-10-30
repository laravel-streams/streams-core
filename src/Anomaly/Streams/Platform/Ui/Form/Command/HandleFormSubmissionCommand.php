<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUi;

/**
 * Class HandleFormSubmissionCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionCommand
{

    /**
     * The form UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUi
     */
    protected $ui;

    /**
     * Create new HandleFormSubmissionCommand instance.
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
     * @return \Anomaly\Streams\Platform\Ui\Form\FormUi
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 