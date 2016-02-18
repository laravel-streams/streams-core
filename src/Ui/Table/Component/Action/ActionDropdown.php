<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ActionDropdown
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionDropdown
{

    /**
     * Flatten the dropdowns
     *
     * @param TableBuilder $builder
     */
    public function flatten(TableBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as $key => &$action) {
            if (isset($action['dropdown'])) {
                foreach (array_pull($action, 'dropdown') as $dropdown) {

                    $dropdown['parent'] = $action['slug'];

                    $actions[] = $dropdown;
                }
            }
        }

        $builder->setActions($actions);
    }

    /**
     * Build dropdown items.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $actions = $builder->getActions();

        foreach ($actions as $key => &$action) {
            if ($dropdown = array_get($action, 'parent')) {

                foreach ($actions as &$parent) {

                    if (array_get($parent, 'slug') == $dropdown) {

                        if (!isset($parent['dropdown'])) {
                            $parent['dropdown'] = [];
                        }

                        $parent['dropdown'][] = $action;
                    }
                }
            }
        }

        $builder->setActions($actions);
    }
}
