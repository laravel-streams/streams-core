<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldTranslator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldTranslator
{

    /**
     * Translate form fields.
     *
     * @param FormBuilder $builder
     */
    public function translate(FormBuilder $builder)
    {
        $translations = [];

        $defaultLocale  = $builder->getConfigValue('app.fallback_locale');
        $enabledLocales = $builder->getConfigValue('streams::locales.enabled');

        /**
         * For each field if the assignment is translatable
         * then duplicate it and set a couple simple
         * parameters to assist in rendering.
         */
        foreach ($builder->getFields() as $field) {

            if (!array_get($field, 'translatable', false)) {

                $translations[] = $field;

                continue;
            }

            foreach ($enabledLocales as $locale) {

                $translation = $field;

                array_set($translation, 'locale', $locale);
                array_set($translation, 'hidden', $locale !== $locale);

                if ($defaultLocale !== $locale) {
                    array_set($translation, 'hidden', true);
                    array_set($translation, 'required', false);
                    array_set($translation, 'rules', array_diff(array_get($translation, 'rules', []), ['required']));
                }

                $translations[] = $translation;
            }
        }

        $builder->setFields($translations);
    }
}
