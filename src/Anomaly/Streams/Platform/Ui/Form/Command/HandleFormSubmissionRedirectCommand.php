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
     * The form UI object.
     *
     * @var
     */
    protected $ui;

    /**
     * Create a new HandleFormSubmissionRedirectCommand instance.
     *
     * @param $ui
     */
    function __construct($ui)
    {
        $this->ui = $ui;
    }

    /**
     * Ger the form UI object.
     *
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 