<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Workflows\Views;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class NormalizeViews
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeViews
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $views = $builder->views;

        foreach ($views as $slug => &$view) {

            /*
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

            /*
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

            /*
             * If the slug is not numeric and the view is an
             * array without a slug then use the slug for
             * the slug for the view.
             */
            if (is_array($view) && !isset($view['slug']) && !is_numeric($slug)) {
                $view['slug'] = $slug;
            }

            /*
             * Make sure we have a view property.
             */
            if (is_array($view) && !isset($view['view'])) {
                $view['view'] = $view['slug'];
            }
        }

        $views = Normalizer::attributes($views);

        /**
         * Go back over and assume HREFs.
         * @todo review this - from guesser
         */
        foreach ($views as $slug => &$view) {

            // Only automate it if not set.
            if (!isset($view['attributes']['href'])) {
                $view['attributes']['href'] = url(
                    request()->path() . '?' . Arr::get($view, 'prefix') . 'view=' . $view['slug']
                );
            }
        }

        $builder->views = $views;
    }
}
