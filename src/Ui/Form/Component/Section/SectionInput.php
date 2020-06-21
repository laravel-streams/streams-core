<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
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
        $sections = resolver($builder->sections, compact('builder'));

        $builder->sections = evaluate($sections ?: $builder->sections, compact('builder'));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function evaluate(FormBuilder $builder)
    {
        $builder->sections = evaluate($builder->sections, compact('builder'));
    }

    /**
     * Normalize the sections.
     *
     * @param FormBuilder $builder
     */
    protected static function normalize(FormBuilder $builder)
    {
        $sections = $builder->sections;

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
            $section['attributes'] = Arr::get($section, 'attributes', []);

            /*
             * Move all data-* keys
             * to attributes.
             */
            foreach ($section as $attribute => $value) {
                if (Str::is('data-*', $attribute)) {
                    Arr::set($section, 'attributes.' . $attribute, Arr::pull($section, $attribute));
                }
            }
        }

        $builder->sections = $sections;
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function translate(FormBuilder $builder)
    {
        $builder->sections = Translator::translate($builder->sections);
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function parse(FormBuilder $builder)
    {
        $builder->sections = Arr::parse($builder->sections);
    }
}
