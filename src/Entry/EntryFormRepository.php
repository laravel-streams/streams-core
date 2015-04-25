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

        $data = [];

        /**
         * Save default translation input.
         *
         * @var FieldType $field
         */
        foreach ($fields->notTranslatable() as $field) {
            if (!$field->getLocale()) {
                array_set($data, $field->getColumnName(), $form->getValue($field->getInputName()));
            }
        }

        /**
         * Loop through available translations
         * and save translated input.
         *
         * @var FieldType $field
         */
        if ($entry->isTranslatable()) {

            foreach (config('streams.available_locales') as $locale => $language) {

                foreach ($fields->translatable() as $field) {

                    if ($field->getLocale() == $locale) {
                        array_set(
                            $data,
                            $locale . '.' . $field->getColumnName(),
                            $form->getValue($field->getInputName())
                        );
                    }
                }
            }
        }

        if ($entry->getId()) {
            $entry->update($data);
        } else {
            $entry->create($data);
        }

        return $entry;
    }
}
