<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Guesser\RedirectGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ActionGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionGuesser
{

    /**
     * The redirect guesser.
     *
     * @var RedirectGuesser
     */
    protected $redirect;

    /**
     * Create a new ActionGuesser instance.
     *
     * @param RedirectGuesser $redirect
     */
    public function __construct(RedirectGuesser $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Guess action properties.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $this->redirect->guess($builder);
    }
}
