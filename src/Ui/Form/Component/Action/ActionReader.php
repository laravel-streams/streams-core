<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

/**
 * Class ActionReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionReader
{

    /**
     * Standardize action configuration input.
     *
     * @param $slug
     * @param $action
     * @return array
     */
    public function standardize($slug, $action)
    {

        /**
         * If the slug is numeric and the action is
         * a string then treat the string as both the
         * action and the slug. This is OK as long as
         * there are not multiple instances of this
         * input using the same action which is not likely.
         */
        if (is_numeric($slug) && is_string($action)) {
            $action = [
                'slug'   => $action,
                'button' => $action,
            ];
        }

        /**
         * If the slug is NOT numeric and the action is a
         * string then use the slug as the slug and the
         * action as the action.
         */
        if (!is_numeric($slug) && is_string($action)) {
            $action = [
                'slug'   => $slug,
                'button' => $action,
            ];
        }

        /**
         * If the slug is not numeric and the action is an
         * array without a slug then use the slug for
         * the slug for the action.
         */
        if (is_array($action) && !isset($action['slug']) && !is_numeric($slug)) {
            $action['slug'] = $slug;
        }

        /**
         * Make sure the attributes array is set.
         */
        $action['attributes'] = array_get($action, 'attributes', []);

        /**
         * If the HREF is present outside of the attributes
         * then pull it and put it in the attributes array.
         */
        if (isset($action['href'])) {
            $action['attributes']['href'] = array_pull($action, 'href');
        }

        return $action;
    }
}
