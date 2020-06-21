<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Illuminate\Support\Arr;
use Illuminate\Translation\Translator;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

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
     * Read builder input.
     *
     * @param  ControlPanelBuilder $builder
     * @return array
     */
    public static function read(ControlPanelBuilder $builder)
    {
        self::resolve($builder);
        self::normalize($builder);
        self::merge($builder);

        ButtonGuesser::guess($builder);

        self::translate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function resolve(ControlPanelBuilder $builder)
    {
        $buttons = resolver($builder->getButtons(), compact('builder'));

        $builder->setButtons(evaluate($buttons ?: $builder->getButtons(), compact('builder')));
    }

    /**
     * Normalize input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected static function normalize(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as $key => &$button) {

            /*
             * If the button is a string but the key
             * is numeric then use the button as the
             * button type.
             */
            if (is_numeric($key) && is_string($button)) {
                $button = [
                    'button' => $button,
                ];
            }

            /*
             * If the button AND key are strings then
             * use the key as the button and the
             * button as the text parameters.
             */
            if (!is_numeric($key) && is_string($button)) {
                $button = [
                    'text'   => $button,
                    'button' => $key,
                ];
            }

            /*
             * If the key is not numeric and the button
             * is an array without the button key then
             * use the key as the button's type.
             */
            if (!is_numeric($key) && is_array($button) && !isset($button['button'])) {
                $button['button'] = $key;
            }
        }

        $buttons = Normalizer::attributes($buttons);

        $builder->setButtons($buttons);
    }

    /**
     * Merge in registered properties.
     *
     * @param ControlPanelBuilder $builder
     */
    protected static function merge(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as &$parameters) {

            if (!$button = Arr::get($parameters, 'button')) {
                continue;
            }

            if ($button && $button = app(ButtonRegistry::class)->get($button)) {
                $parameters = array_replace_recursive($button, $parameters);
            }

            $button = Arr::get($parameters, 'button', $button);

            if ($button && $button = app(ButtonRegistry::class)->get($button)) {
                $parameters = array_replace_recursive($button, $parameters);
            }
        }

        $builder->setButtons($buttons);
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function parse(ControlPanelBuilder $builder)
    {
        $builder->setButtons(Arr::parse($builder->getButtons()));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function translate(ControlPanelBuilder $builder)
    {
        $builder->setButtons(Translator::translate($builder->getButtons()));
    }
}
