<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Workflows\Actions;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class NormalizeActions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeActions
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $actions = $builder->actions;

        if ($builder->instance->options->get('sortable')) {
            $actions = array_merge(['reorder'], $actions);
        }

        foreach ($actions as $slug => &$action) {

            /*
             * If the slug is numeric and the action is
             * a string then treat the string as both the
             * action and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same action which is not likely.
             */
            if (is_numeric($slug) && is_string($action)) {
                $action = [
                    'slug' => $action,
                    'action' => $action,
                ];
            }

            /*
             * If the slug is NOT numeric and the action is a
             * string then use the slug as the slug and the
             * action as the action.
             */
            if (!is_numeric($slug) && is_string($action)) {
                $action = [
                    'slug' => $slug,
                    'action' => $action,
                ];
            }

            /*
             * If the slug is not numeric and the action is an
             * array without a slug then use the slug for
             * the slug for the action.
             */
            if (is_array($action) && !isset($action['slug']) && !is_numeric($slug)) {
                $action['slug'] = $slug;
            }

            /*
             * Make sure we have a action property.
             */
            if (is_array($action) && !isset($action['action'])) {
                $action['action'] = $action['slug'];
            }
        }

        $actions = Normalizer::attributes($actions);

        /**
         * Go back over and assume HREFs.
         * @todo reaction this - from guesser
         */
        foreach ($actions as $slug => &$action) {
            //
        }

        $builder->actions = $actions;
    }
}
