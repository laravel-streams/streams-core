<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionInterface;

/**
 * Class ActionFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionFactory extends ButtonFactory
{

    /**
     * The default button.
     *
     * @var string
     */
    protected $button = 'Anomaly\Streams\Platform\Ui\Form\Component\Action\Action';

    /**
     * Make an action.
     *
     * @param  array $parameters
     * @return ActionInterface
     */
    public function make(array $parameters)
    {
        return parent::make($parameters);
    }
}
