<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepository;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Illuminate\Http\Request;

/**
 * Class EntryFormRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryFormRepository implements FormRepository
{

    /**
     * The form model.
     *
     * @var EntryModel
     */
    protected $model;

    /**
     * Create a new EloquentFormRepository instance.
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
        $entry   = $form->getEntry();
        $fields  = $form->getFields();
        $request = $form->getRequest();

        if (!$entry instanceof EntryModel) {
            return false;
        }

        /**
         * Save default translation input.
         */
        foreach ($fields as $field) {
            if ($field instanceof FieldType) {
                $entry->{$field->getInputName()} = $request->get($field->getInputName());
            }
        }

        $entry->save();

        /**
         * Loop through available translations
         * and save translated input.
         */
        if ($entry->isTranslatable()) {

            foreach (config('streams::config.available_locales') as $locale) {

                //  Skip default - already did it.
                if ($locale == config('app.locale')) {
                    continue;
                }

                $entry = $entry->translate($locale);

                foreach ($fields as $field) {

                    if ($field instanceof FieldType) {
                        $entry->{$field->getInputName()} = $request->get($field->getInputName());
                    }
                }

                $entry->save();
            }
        }
    }
}
