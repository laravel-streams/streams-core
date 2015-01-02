<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

/**
 * Class ViewNormalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewNormalizer
{

    /**
     * Normalize the view input.
     *
     * @param array $views
     * @return array
     */
    public function normalize(array $views)
    {
        foreach ($views as $slug => &$view) {

            /**
             * If the slug is numeric and the view is
             * a string then treat the string as both the
             * view and the slug. This is OK as long as
             * there are not multiple instances of this
             * input using the same view which is not likely.
             */
            if (is_numeric($slug) && is_string($view)) {
                $view = [
                    'slug' => $view,
                    'view' => $view,
                ];
            }

            /**
             * If the slug is NOT numeric and the view is a
             * string then use the slug as the slug and the
             * view as the view.
             */
            if (!is_numeric($slug) && is_string($view)) {
                $view = [
                    'slug' => $slug,
                    'view' => $view,
                ];
            }

            /**
             * If the slug is not numeric and the view is an
             * array without a slug then use the slug for
             * the slug for the view.
             */
            if (is_array($view) && !isset($view['slug']) && !is_numeric($slug)) {
                $view['slug'] = $slug;
            }
        }

        return $views;
    }
}
