<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SegmentNormalizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SegmentNormalizer
{

    /**
     * Normalize the segment input.
     *
     * @param TreeBuilder $builder
     */
    public function normalize(TreeBuilder $builder)
    {
        $segments = $builder->getSegments();

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
             * Move all data-* keys
             * to attributes.
             */
            foreach ($segment as $attribute => $value) {
                if (str_is('data-*', $attribute)) {
                    array_set($segment, 'attributes.' . $attribute, array_pull($segment, $attribute));
                }
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

        $builder->setSegments($segments);
    }
}
