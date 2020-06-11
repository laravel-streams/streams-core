<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\HrefGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\TextGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\TypeGuesser;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\Guesser\EnabledGuesser;

/**
 * Class ButtonGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonGuesser
{

    /**
     * Guess button properties.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guess(ControlPanelBuilder $builder)
    {
        self::guessType($builder);
        self::guessHref($builder);
        self::guessText($builder);
        self::guessEnabled($builder);
    }

    /**
     * Guess the button from the hint.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guessType(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        $module = app('module.collection')->active();

        /*
         * This will break if we can't figure
         * out what the active module is.
         */
        if (!$module instanceof Module) {
            return;
        }

        foreach ($buttons as &$button) {

            /*
             * If the button starts with "new_" just use
             * "new" and move the rest to the text.
             */
            if (isset($button['button']) && Str::startsWith($button['button'], 'new_')) {

                if (!isset($button['text'])) {

                    $text = $module->getNamespace('button.' . $button['button']);

                    if (trans()->has($text)) {
                        $button['text'] = $text;
                    }
                }

                // Change this to slug for later.
                $button['slug'] = $button['button'];

                Arr::set($button, 'button', substr($button['button'], 0, 3));
                Arr::set($button, 'primary', Arr::get($button, 'primary', true));
            }

            /*
             * If the button starts with "add_" just use
             * "add" and move the rest to the text.
             */
            if (isset($button['button']) && Str::startsWith($button['button'], 'add_')) {
                if (!isset($button['text'])) {
                    $button['text'] = $module->getNamespace('button.' . $button['button']);
                }

                // Change this to slug for later.
                $button['slug'] = $button['button'];

                Arr::set($button, 'button', substr($button['button'], 0, 3));
            }
        }

        $builder->setButtons($buttons);
    }

    /**
     * Guess the HREF for a button.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guessHref(ControlPanelBuilder $builder)
    {
        $buttons  = $builder->getButtons();
        $sections = $builder->getControlPanelSections();

        $active = $sections->active();
        $module = app('module.collection')->active();

        foreach ($buttons as &$button) {

            // If we already have an HREF then skip it.
            if (isset($button['attributes']['href'])) {
                continue;
            }

            // Determine the HREF based on the button type.
            switch (Arr::get($button, 'button')) {

                case 'add':
                case 'new':
                case 'create':
                    $button['attributes']['href'] = $active->href('create');
                    break;

                case 'export':
                    if ($module) {
                        $button['attributes']['href'] = url(
                            'entry/handle/export/' . $module->getNamespace() . '/' . Arr::get(
                                $button,
                                'namespace'
                            ) . '/' . Arr::get($button, 'stream')
                        );
                    }
                    break;
            }

            $type = Arr::get($button, 'segment', Arr::get($button, 'button'));

            if (!isset($button['attributes']['href']) && $type) {
                $button['attributes']['href'] = $active->href($type);
            }
        }

        $builder->setButtons($buttons);
    }

    /**
     * Guess the button from the hint.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guessText(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        $module = app('module.collection')->active();

        /*
         * This will break if we can't figure
         * out what the active module is.
         */
        if (!$module instanceof Module) {
            return;
        }

        foreach ($buttons as &$button) {
            if (isset($button['text'])) {
                continue;
            }

            if (!isset($button['button'])) {
                continue;
            }

            $text = $module->getNamespace('button.' . $button['button']);

            if (!isset($button['text']) && trans()->has($text)) {
                $button['text'] = $text;
            }

            if (
                (!isset($button['text']) || !trans()->has($button['text']))
                && config('streams.system.lazy_translations')
            ) {
                $button['text'] = ucwords(humanize(Arr::get($button, 'slug', $button['button'])));
            }

            if (!isset($button['text'])) {
                $button['text'] = $text;
            }
        }

        $builder->setButtons($buttons);
    }

    /**
     * Guess the enabled property.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function guessEnabled(ControlPanelBuilder $builder)
    {
        $buttons = $builder->getButtons();

        foreach ($buttons as &$button) {

            if (!isset($button['enabled']) || is_bool($button['enabled'])) {
                continue;
            }

            /**
             * This is handy for looking at query string input
             * and toggling buttons on and off if there is a value.
             */
            if (is_string($button['enabled']) && is_numeric($button['enabled'])) {
                $button['enabled'] = true;
            }

            /**
             * This is handy for looking at the URI path
             * and toggling buttons on and off if matching.
             */
            if (is_string($button['enabled'])) {
                $button['enabled'] = Str::is($button['enabled'], request()->path());
            }
        }

        $builder->setButtons($buttons);
    }
}
