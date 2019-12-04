<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ViewInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewInput
{

    /**
     * Read builder view input.
     *
     * @param  TableBuilder $builder
     * @return array
     */
    public static function read(TableBuilder $builder)
    {
        self::resolve($builder);
        self::defaults($builder);
        self::normalize($builder);
        self::merge($builder);
        self::translate($builder);
        self::parse($builder);

        ViewGuesser::guess($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function resolve(TableBuilder $builder)
    {
        $views = resolver($builder->getViews(), compact('builder'));

        $builder->setViews(evaluate($views ?: $builder->getViews(), compact('builder')));
    }

    /**
     * Default input.
     *
     * @param TableBuilder $builder
     */
    protected static function defaults(TableBuilder $builder)
    {
        if (!$stream = $builder->getTableStream()) {
            return;
        }

        if ($stream->isTrashable() && !$builder->getViews() && !$builder->isAjax()) {
            $builder->setViews([
                'all',
                'trash',
            ]);
        }
    }

    /**
     * Normalize input.
     *
     * @param TableBuilder $builder
     */
    protected static function normalize(TableBuilder $builder)
    {
        $views = $builder->getViews();

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

        $builder->setViews($views);
    }

    /**
     * Merge input.
     *
     * @param TableBuilder $builder
     */
    protected static function merge(TableBuilder $builder)
    {
        $views = $builder->getViews();

        foreach ($views as &$parameters) {
            if ($view = app(ViewRegistry::class)->get(array_get($parameters, 'view'))) {
                $parameters = array_replace_recursive($view, array_except($parameters, ['view']));
            }
        }

        $builder->setViews($views);
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function parse(TableBuilder $builder)
    {
        $builder->setViews(parse($builder->getViews()));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function translate(TableBuilder $builder)
    {
        $builder->setViews(translate($builder->getViews()));
    }
}
