<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Illuminate\Support\Arr;
use Illuminate\Translation\Translator;
use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldInput
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldInput
{

    /**
     * Read the form input.
     *
     * @param FormBuilder $builder
     */
    public static function read(FormBuilder $builder)
    {
        self::resolve($builder);
        self::defaults($builder);
        self::normalize($builder);
        self::fill($builder);
        self::normalize($builder); //Yes, again.

        FieldGuesser::guess($builder);

        self::translate($builder);
        self::parse($builder);

        self::populate($builder); // Do this last.
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function resolve(FormBuilder $builder)
    {
        $fields = resolver($builder->fields, compact('builder'));

        $builder->fields = evaluate($fields ?: $builder->fields, compact('builder'));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function evaluate(FormBuilder $builder)
    {
        $builder->fields = evaluate($builder->fields, compact('builder'));
    }

    /**
     * Default input.
     *
     * @param FormBuilder $builder
     */
    protected static function defaults(FormBuilder $builder)
    {
        if ($builder->fields === []) {
            $builder->fields = (['*']);
        }
    }

    /**
     * Normalize input.
     *
     * @param FormBuilder $builder
     */
    protected static function normalize(FormBuilder $builder)
    {
        $fields = $builder->fields;

        foreach ($fields as $slug => &$field) {

            /*
             * If the field is a wild card marker
             * then just continue.
             */
            if ($field == '*') {
                continue;
            }

            /*
             * If the slug is numeric and the field
             * is a string then use the field as is.
             */
            if (is_numeric($slug) && is_string($field)) {
                $field = [
                    'field' => $field,
                ];
            }

            /*
             * If the slug is a string and the field
             * is a string too then use the field as the
             * type and the field as well.
             */
            if (!is_numeric($slug) && is_string($slug) && is_string($field)) {
                $field = [
                    'field' => $slug,
                    'type'  => $field,
                ];
            }

            /*
             * If the field is an array and does not
             * have the field parameter set then
             * use the slug.
             */
            if (is_array($field) && !isset($field['field'])) {
                $field['field'] = $slug;
            }

            /*
             * If the field is required then it must have
             * the rule as well.
             */
            if (Arr::get($field, 'required') === true) {
                $field['rules'] = array_unique(array_merge(Arr::get($field, 'rules', []), ['required']));
            }
        }

        $builder->setFields($fields);
    }

    /**
     * Fill in fields.
     *
     * @param FormBuilder $builder
     */
    protected static function fill(FormBuilder $builder)
    {
        $fields = $builder->fields;
        $stream = $builder->getFormStream();

        /*
         * If no Stream, skip it.
         */
        if (!$stream) {
            if (array_search('*', $fields) !== false) {
                unset($fields[array_search('*', $fields)]);

                $builder->setFields($fields);
            }

            return;
        }

        /*
         * Fill with everything by default.
         */
        $fill = $stream->fields->slugs()->all();

        /*
         * Loop over field configurations and unset
         * them from the fill fields.
         *
         * If we come across the fill marker then
         * set the position.
         */
        foreach ($fields as $parameters) {
            if (is_string($parameters) && $parameters === '*') {
                continue;
            }

            /**
             * If we found a field then
             * unset it from the fill fields.
             */
            if (($search = array_search($parameters['field'], $fill)) !== false) {
                unset($fill[$search]);
            }
        }

        /*
         * If we have a fill marker then splice
         * in the remaining fill fields in place
         * of the fill marker.
         */
        if (($position = array_search('*', $fields)) !== false) {
            array_splice($fields, $position, null, $fill);

            unset($fields[array_search('*', $fields)]);
        }

        $builder->setFields($fields);
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function parse(FormBuilder $builder)
    {
        $builder->setFields(Arr::parse($builder->fields));
    }

    /**
     * Translate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\Form\FormBuilder $builder
     */
    protected static function translate(FormBuilder $builder)
    {
        $translations = [];

        $defaultLocale  = config('streams.locales.default');
        $enabledLocales = config('streams.locales.enabled');

        /*
         * For each field if the stream is translatable
         * then duplicate it and set a couple simple
         * parameters to assist in rendering.
         */
        foreach ($builder->fields as $field) {

            if (!Arr::get($field, 'translatable', false)) {

                $translations[] = $field;

                continue;
            }

            if (isset($field['locale'])) {

                Arr::set($field, 'hidden', $field['locale'] !== $defaultLocale);

                if ($field['locale'] !== $defaultLocale) {
                    Arr::set($field, 'hidden', true);
                    Arr::set($field, 'required', false);
                    Arr::set($field, 'rules', array_diff(Arr::get($field, 'rules', []), ['required']));
                }

                $translations[] = $field;

                continue;
            }

            foreach ($enabledLocales as $locale) {

                $translation = $field;

                Arr::set($translation, 'locale', $locale);
                Arr::set($translation, 'hidden', Arr::get($field, 'hidden', false) ?: ($locale !== $locale));

                if ($value = Arr::get($field, 'values.' . $locale)) {
                    Arr::set($translation, 'value', $value);
                }

                if ($defaultLocale !== $locale) {
                    Arr::set($translation, 'hidden', true);
                    Arr::set($translation, 'required', false);
                    Arr::set($translation, 'rules', array_diff(Arr::get($translation, 'rules', []), ['required']));
                }

                $translations[] = $translation;
            }
        }

        $builder->setFields(Translator::translate($translations));
    }

    /**
     * Populate the fields with entry values.
     *
     * @param FormBuilder $builder
     */
    protected static function populate(FormBuilder $builder)
    {
        $fields = $builder->fields;
        $entry  = $builder->getFormEntry();

        /**
         * This is a brute force fix for the
         * url.intended that is set by Laravel
         * for redirecting kicked login attempts.
         *
         * URL intended becomes an empty url array.
         *
         * Since we're here - we don't need it anyways.
         */
        if (!session()->get('url')) {
            session()->pull('url');
        }

        foreach ($fields as &$field) {

            /*
             * If the field is not already set
             * then get the value off the entry.
             *
             * @var todo
             * This needs to be tweaked slightly for duplication in the near future.
             * The " && $entry->getKey()" get's removed but needs replaced with something duplication specific.
             */
            if (!isset($field['value']) && $entry instanceof Model && $entry->getKey()) {

                $locale = Arr::get($field, 'locale');

                if ($locale && $translation = $entry->translate($locale)) {
                    $field['value'] = $translation->getFieldValue($field['field']);
                } else {
                    $field['value'] = $entry->{$field['field']};
                }
            }

            /*
             * If the field has a default value
             * and the entry does not exist yet
             * then use the default value.
             */
            if (isset($field['config']['default_value']) && $entry instanceof Model && !$entry->getKey()) {
                $field['value'] = $field['config']['default_value'];
            }

            /*
             * If the field has a default value
             * and there is no entry then
             * use the default value.
             */
            if (isset($field['config']['default_value']) && !$entry) {
                $field['value'] = $field['config']['default_value'];
            }

            /*
             * If the field is a stream field then
             * use it's config for the default value.
             */
            if (
                !isset($field['value']) && $entry instanceof Model && $type = $entry->stream()->fields->get($field['field'])->type()
            ) {
                $field['value'] = Arr::get($type->getConfig(), 'default_value');
            }

            /*
             * Lastly if we have flashed data from a front end
             * form handler then use that value for the field.
             */
            if (session()->has($field['prefix'] . $field['field'])) {
                $field['value'] = session()->pull($field['prefix'] . $field['field']);
            }
        }

        $builder->setFields($fields);
    }
}
