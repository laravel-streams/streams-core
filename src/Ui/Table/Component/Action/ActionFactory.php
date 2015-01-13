<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionInterface;

/**
 * Class ActionFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionFactory
{

    /**
     * The default action.
     *
     * @var string
     */
    protected $action = 'Anomaly\Streams\Platform\Ui\Table\Component\Action\Action';

    /**
     * The action registry.
     *
     * @var ActionRegistry
     */
    protected $actions;

    /**
     * The button registry.
     *
     * @var ButtonRegistry
     */
    protected $buttons;

    /**
     * Create a new ActionFactory instance.
     *
     * @param ActionRegistry $actions
     * @param ButtonRegistry $buttons
     */
    function __construct(ActionRegistry $actions, ButtonRegistry $buttons)
    {
        $this->actions = $actions;
        $this->buttons = $buttons;
    }

    /**
     * Make an action.
     *
     * @param  array $parameters
     * @return ActionInterface
     */
    public function make(array $parameters)
    {
        $action = $original = array_get($parameters, 'action');

        if ($action && $action = $this->actions->get($action)) {
            $parameters = array_replace_recursive($action, array_except($parameters, 'action'));
        }

        $button = array_get($parameters, 'button', $original);

        if ($button && $button = $this->buttons->get($button)) {
            $parameters = array_replace_recursive($button, array_except($parameters, 'button'));
        }

        $action = array_get($parameters, 'action', $this->action);

        if ($action && class_exists($action)) {
            $action = app()->make($action, $parameters);
        } else {
            $action = app()->make($this->action, $parameters);
        }

        $this->hydrate($action, $parameters);

        return $action;
    }

    /**
     * Hydrate the button with it's remaining parameters.
     *
     * @param ActionInterface $action
     * @param array           $parameters
     */
    protected function hydrate(ActionInterface $action, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($action, $method)) {
                $action->{$method}($value);
            }
        }
    }
}
