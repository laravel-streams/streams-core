<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Edit;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Export;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Reorder;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\ForceDelete;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry as ButtonButtonRegistry;

/**
 * Class ButtonRegistry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonRegistry extends ButtonButtonRegistry
{

    /**
     * Get a button.
     *
     * @param  $button
     * @return array|null
     */
    public function get($button)
    {
        if (!$button) {
            return null;
        }

        $registered = Arr::get($this->buttons, $button);

        if ($button = parent::get(Arr::get($registered, 'button'))) {
            $registered = array_replace_recursive($button, Arr::except($registered, ['button']));
        }

        return $registered;
    }

    /**
     * Register a action.
     *
     * @param        $action
     * @param  array $parameters
     * @return $this
     */
    public function register($action, array $parameters)
    {
        Arr::set($this->actions, $action, $parameters);

        return $this;
    }
}
