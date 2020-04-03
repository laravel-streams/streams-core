<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SectionInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionInput
{

    /**
     * Read the form section input.
     *
     * @param FormBuilder $builder
     */
    public static function read(FormBuilder $builder)
    {
        self::resolve($builder);
        self::evaluate($builder);
        self::normalize($builder);
        self::translate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function resolve(FormBuilder $builder)
    {
        $sections = resolver($builder->getSections(), compact('builder'));

        $builder->setSections(evaluate($sections ?: $builder->getSections(), compact('builder')));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function evaluate(FormBuilder $builder)
    {
        $builder->setSections(evaluate($builder->getSections(), compact('builder')));
    }

    /**
     * Normalize the sections.
     *
     * @param FormBuilder $builder
     */
    protected static function normalize(FormBuilder $builder)
    {
        $sections = $builder->getSections();

        foreach ($sections as $slug => &$section) {

            if (is_string($section)) {
                $section = [
                    'view' => $section,
                ];
            }

            /**
             * If tabs are defined but no orientation
             * then default to standard tabs.
             */
            if (isset($section['tabs']) && !isset($section['orientation'])) {
                $section['orientation'] = 'horizontal';
            }

            /*
             * Make sure some default parameters exist.
             */
            $section['attributes'] = array_get($section, 'attributes', []);

            /*
             * Move all data-* keys
             * to attributes.
             */
            foreach ($section as $attribute => $value) {
                if (str_is('data-*', $attribute)) {
                    array_set($section, 'attributes.' . $attribute, array_pull($section, $attribute));
                }
            }
        }

        $builder->setSections($sections);
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function translate(FormBuilder $builder)
    {
        $builder->setSections(translate($builder->getSections()));
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function parse(FormBuilder $builder)
    {
        $builder->setSections(Arr::parse($builder->getSections()));
    }
}
