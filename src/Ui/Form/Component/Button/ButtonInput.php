<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;

/**
 * Class ButtonInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonInput
{

    /**
     * Read builder button input.
     *
     * @param FormBuilder $builder
     */
    public static function read(FormBuilder $builder)
    {
        self::resolve($builder);
        self::defaults($builder);
        self::normalize($builder);
        self::merge($builder);

        ButtonGuesser::guess($builder);

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
        $buttons = resolver($builder->getButtons(), compact('builder'));

        $builder->setButtons(evaluate($buttons ?: $builder->getButtons(), compact('builder')));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function evaluate(FormBuilder $builder)
    {
        $builder->setButtons(evaluate($builder->getButtons(), compact('builder')));
    }

    /**
     * Default the form buttons when none are defined.
     *
     * @param FormBuilder $builder
     */
    protected static function defaults(FormBuilder $builder)
    {
        if ($builder->getButtons() === [] && request()->segment(1) == 'admin') {
            $builder->addButton('cancel');
        }
    }

    /**
     * Normalize button input.
     *
     * @param FormBuilder $builder
     */
    protected static function normalize(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            /*
            * If the button is a string then use
            * it as the button parameter.
            */
            if (is_string($button)) {
                $button = [
                    'button' => $button,
                ];
            }

            /*
            * If the key is a string and the button
            * is an array without a button param then
            * move the key into the button as that param.
            */
            if (!is_integer($key) && !isset($button['button'])) {
                $button['button'] = $key;
            }
        }

        $buttons = Normalizer::attributes($buttons);

        $builder->setButtons($buttons);
    }

    /**
     * Merge in registered properties.
     *
     * @param FormBuilder $builder
     */
    protected static function merge(FormBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as &$parameters) {
            if ($button = app(ButtonRegistry::class)->get(array_get($parameters, 'button'))) {
                $parameters = array_replace_recursive($button, $parameters);
            }
        }

        $builder->setButtons($buttons);
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function parse(FormBuilder $builder)
    {
        $builder->setButtons(Arr::parse($builder->getButtons()));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function translate(FormBuilder $builder)
    {
        $builder->setButtons(translate($builder->getButtons()));
    }
}
