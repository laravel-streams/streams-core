<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class EloquentFormRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentFormRepository implements FormRepositoryInterface
{

    /**
     * The form model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new EloquentFormRepositoryInterface instance.
     *
     * @param EloquentModel $model
     */
    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find an entry.
     *
     * @param $id
     * @return EloquentModel
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
     * @return EloquentModel
     */
    public function save(FormBuilder $builder)
    {
        $form = $builder->getForm();

        $entry = $form->getEntry();

        /**
         * Save default translation input.
         *
         * @var FieldType $field
         */
        foreach ($form->getFields() as $field) {
            if (starts_with($field->getField(), 'config')) {
                continue;
            }
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

                foreach ($form->getFields() as $field) {

                    if (!$entry->isTranslatedAttribute($field->getField())) {
                        continue;
                    }

                    if ($field->getLocale() == $locale) {
                        $translation->{$field->getColumnName()} = $form->getValue($field->getInputName());
                    }
                }

                $translation->save();
            }
        }

        return $entry;
    }
}
