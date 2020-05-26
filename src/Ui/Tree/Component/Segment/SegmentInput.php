<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class SegmentInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentInput
{

    /**
     * Read the builder's segment input.
     *
     * @param TreeBuilder $builder
     */
    public static function read(TreeBuilder $builder)
    {
        self::resolve($builder);
        self::defaults($builder);
        self::normalize($builder);
        self::parse($builder);
        self::translate($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Tree\TreeBuilder $builder
     */
    protected static function resolve(TreeBuilder $builder)
    {
        $segments = resolver($builder->segments, compact('builder'));

        $builder->segments = evaluate($segments ?: $builder->segments, compact('builder'));
    }

    /**
     * Default input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Tree\TreeBuilder $builder
     */
    protected static function defaults(TreeBuilder $builder)
    {
        if ($builder->segments) {
            return;
        }

        if (!$section = cp()->sections->active()) {
            return;
        }

        $builder->segments = [
                [
                    'wrapper' => '<a href="' . $section->getHref('edit') . '/{entry.id}">{value}</a>',
                    'value'   => 'entry.title',
                ],
            ];
    }

    /**
     * Normalize input.
     *
     * @param TreeBuilder $builder
     */
    protected static function normalize(TreeBuilder $builder)
    {
        $segments = $builder->segments;

        foreach ($segments as $key => &$segment) {

            /*
             * If the key is non-numerical then
             * use it as the header and use the
             * segment as the segment if it's a class.
             */
            if (!is_numeric($key) && !is_array($segment) && class_exists($segment)) {
                $segment = [
                    'heading' => $key,
                    'segment' => $segment,
                ];
            }

            /*
             * If the key is non-numerical then
             * use it as the header and use the
             * segment as the value.
             */
            if (!is_numeric($key) && !is_array($segment) && !class_exists($segment)) {
                $segment = [
                    'heading' => $key,
                    'value'   => $segment,
                ];
            }

            /*
             * If the segment is not already an
             * array then treat it as the value.
             */
            if (!is_array($segment)) {
                $segment = [
                    'value' => $segment,
                ];
            }

            /*
             * If the key is non-numerical and
             * the segment is an array without
             * a value then use the key.
             */
            if (!is_numeric($key) && is_array($segment) && !isset($segment['value'])) {
                $segment['value'] = $key;
            }

            /*
             * If no value wrap is set
             * then use a default.
             */
            array_set($segment, 'wrapper', array_get($segment, 'wrapper', '{value}'));

            /*
             * If there is no value then use NULL
             */
            array_set($segment, 'value', array_get($segment, 'value', null));
        }

        $segments = Normalizer::attributes($segments);

        $builder->segments = $segments;
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Tree\TreeBuilder $builder
     */
    protected static function parse(TreeBuilder $builder)
    {
        $builder->segments = Str::parse($builder->segments);
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Tree\TreeBuilder $builder
     */
    protected static function translate(TreeBuilder $builder)
    {
        $builder->segments = translate($builder->segments);
    }
}
