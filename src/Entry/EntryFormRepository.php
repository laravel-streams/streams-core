<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class EntryFormRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryFormRepository implements FormRepositoryInterface
{

    /**
     * The form model.
     *
     * @var EntryModel
     */
    protected $model;

    /**
     * Create a new EloquentFormRepositoryInterface instance.
     *
     * @param EntryModel $model
     */
    public function __construct(EntryModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find an entry.
     *
     * @param $id
     * @return EntryModel
     */
    public function findOrNew($id)
    {
        $entry = $this->model->find($id);

        if (!$entry) {
            $entry = $this->model->newInstance();
        }

        return $entry;
    }

    /**
     * Save the form.
     *
     * @param FormBuilder $builder
     * @return EntryInterface
     */
    public function save(FormBuilder $builder)
    {
        $form = $builder->getForm();

        $entry  = $form->getEntry();
        $fields = $form->getFields();

        /**
         * Save default translation input.
         *
         * @var FieldType $field
         */
        foreach ($fields->immediate() as $field) {
            if (!$field->getLocale()) {
                $entry->{$field->getColumnName()} = $form->getValue($field->getInputName());
            }
        }

        $entry->save();

        /**
         * Save default translation input (deferred).
         */
        foreach ($fields->deferred() as $field) {
            if (!$field->getLocale()) {
                $entry->{$field->getColumnName()} = $form->getValue($field->getInputName());
            }
        }

        $entry->save();

        /**
         * Loop through available translations
         * and save translated input.
         */
        if ($entry->isTranslatable()) {

            foreach (config('streams.available_locales') as $locale => $language) {

                $translation = $entry->translateOrNew($locale);

                foreach ($fields as $field) {

                    if (!$entry->assignmentIsTranslatable($field->getField())) {
                        continue;
                    }

                    if ($field instanceof FieldType && $field->getLocale() == $locale) {
                        $translation->{$field->getColumnName()} = $form->getValue($field->getInputName());
                    }
                }

                $translation->save();
            }
        }

        return $entry;
    }
}
