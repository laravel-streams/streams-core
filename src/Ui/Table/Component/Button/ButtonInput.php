<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
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
     * @param TableBuilder $builder
     */
    public static function read(TableBuilder $builder)
    {
        self::resolve($builder);
        self::normalize($builder);
        self::merge($builder);

        ButtonGuesser::guess($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function resolve(TableBuilder $builder)
    {
        $buttons = resolver($builder->buttons, compact('builder'));

        $builder->buttons = evaluate($buttons ?: $builder->buttons, compact('builder'));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Table\TableBuilder $builder
     */
    protected static function evaluate(TableBuilder $builder)
    {
        $builder->buttons = evaluate($builder->buttons, compact('builder'));
    }

    /**
     * Normalize button input.
     *
     * @param TableBuilder $builder
     */
    protected static function normalize(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        foreach ($buttons as $key => &$button) {

            /*
            * If the button is a string and
            * the key is an integer then use
            * as the button and slug parameter.
            */
            if (is_integer($key) && is_string($button)) {
                $button = [
                    'slug'   => $button,
                    'button' => $button,
                ];
            }

            /*
            * If the button is a string and
            * the key is NOT an integer then use
            * it as the button parameter only.
            */
            if (!is_integer($key) && is_string($button)) {
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

            /*
            * If the key is a string and the button
            * is an array without a slug param then
            * move the key into the button as that param.
            */
            if (!is_integer($key) && !isset($button['slug'])) {
                $button['slug'] = $key;
            }
        }

        $buttons = Normalizer::attributes($buttons);

        $builder->buttons = $buttons;
    }

    /**
     * Merge in registered properties.
     *
     * @param TableBuilder $builder
     */
    protected static function merge(TableBuilder $builder)
    {
        $buttons = $builder->buttons;

        foreach ($buttons as &$parameters) {
            if ($button = app(ButtonRegistry::class)->get(Arr::get($parameters, 'button'))) {
                $parameters = array_replace_recursive($button, $parameters);
            }
        }

        $builder->buttons = $buttons;
    }
}
