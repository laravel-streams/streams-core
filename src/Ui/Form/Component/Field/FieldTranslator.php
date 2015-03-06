<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\LocalizationModule\Language\Contract\LanguageRepositoryInterface;
use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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
     * The setting repository.
     *
     * @var SettingRepositoryInterface
     */
    protected $settings;

    /**
     * The language repository.
     *
     * @var LanguageRepositoryInterface
     */
    protected $languages;

    /**
     * Create a new FieldTranslator instance.
     *
     * @param SettingRepositoryInterface  $settings
     * @param LanguageRepositoryInterface $languages
     */
    public function __construct(SettingRepositoryInterface $settings, LanguageRepositoryInterface $languages)
    {
        $this->settings  = $settings;
        $this->languages = $languages;
    }


    /**
     * Translate form fields.
     *
     * @param FormBuilder $builder
     */
    public function translate(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $entry  = $builder->getFormEntry();

        $locale    = $this->settings->get('streams::default_locale', config('app.locale'));
        $languages = $this->languages->enabled();

        /**
         * If the entry is not of the interface then skip it.
         */
        if (!$entry instanceof EntryInterface) {
            return;
        }

        /**
         * If the entry is not translatable then skip it.
         */
        if (!$entry->isTranslatable()) {
            return;
        }

        $translations = [];

        /**
         * For each field if the assignment is translatable
         * then duplicate it and set a couple simple
         * parameters to assist in rendering.
         */
        foreach ($fields as $field) {

            $assignment = $entry->getAssignment($field['field']);

            if (!$assignment || !$assignment->isTranslatable()) {

                $translations[] = $field;

                continue;
            }

            foreach ($languages as $language) {

                $translation = $field;

                array_set($translation, 'locale', $language->iso);
                array_set($translation, 'hidden', $language->iso !== $locale);

                if ($locale !== $language->iso) {
                    array_set($translation, 'required', false);
                }

                $translations[] = $translation;
            }
        }

        $builder->setFields($translations);
    }
}
