<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

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
     * @param Form $form
     * @return bool|mixed
     */
    public function save(Form $form)
    {
        $entry  = $form->getEntry();
        $fields = $form->getFields();

        if (!$entry instanceof EntryModel) {
            return false;
        }

        /**
         * Save default translation input.
         */
        foreach ($fields->immediate() as $field) {
            if ($field instanceof FieldType && !$field->getLocale()) {
                $entry->{$field->getColumnName()} = $form->getValue($field->getInputName());
            }
        }

        $entry->save();

        /**
         * Save default translation input (deferred).
         */
        foreach ($fields->deferred() as $field) {
            if ($field instanceof FieldType && !$field->getLocale()) {
                $entry->{$field->getColumnName()} = $form->getValue($field->getInputName());
            }
        }

        $entry->save();

        /**
         * Loop through available translations
         * and save translated input.
         */
        if ($entry->isTranslatable()) {

            foreach (config('streams.available_locales') as $locale) {

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
    }
}
