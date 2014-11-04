<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class HandleFormSubmissionValidationCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionValidationCommand
{

    /**
     * The form UI object.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new HandleFormSubmissionValidationCommand instance.
     *
     * @param Form $ui
     */
    function __construct(Form $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Get the form UI object.
     *
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 