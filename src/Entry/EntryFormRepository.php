<?php namespace Anomaly\Streams\Platform\Entry;

use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Entry\Traits\Versionable;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepositoryInterface;

/**
 * Class EntryFormRepositoryInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryFormRepository implements FormRepositoryInterface
{

    /**
     * The form model.
     *
     * @var Model
     */
    protected $model;

    /**
     * Create a new EloquentFormRepositoryInterface instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find an entry.
     *
     * @param $id
     * @return Model
     */
    public function findOrNew($id)
    {
        return $this->model->findOrNew($id);
    }

    /**
     * Save the form.
     *
     * @param FormBuilder $builder
     */
    public function save(FormBuilder $builder)
    {
        $entry = $builder->getFormEntry();

        $classes = class_uses_recursive($entry);

        /**
         * If the model is versionable let's disable
         * that here since the model will potentially
         * have post-processing relationships.
         * We're handling this ourselves.
         *
         * See: \Anomaly\Streams\Platform\Ui\Form\Command\HandleVersioning
         * in `post` stage.
         *
         * @var Versionable|EntryModel|Model $entry
         */
        if ($builder->versioningEnabled() && in_array(Versionable::class, $classes)) {
            $enabled = !$entry->versioningDisabled();

            $entry->disableVersioning();
        }

        $data = $this->prepareValueData($builder);

        $entry->unguard();

        $builder->fire('querying', compact('builder'));

        /**
         * Update OR create the entry.
         * Keep this as is or we will
         * have issues with post relations
         * in following observer logic.
         */
        if ($entry->getKey()) {
            $entry->update($data);
        } else {
            $entry = $entry->create($data);
        }

        $entry->reguard();

        $builder->setFormEntry($entry);

        $this->processSelfHandlingFields($builder);

        /**
         * Enable versioning again
         * if it was enabled before.
         */
        if ($builder->versioningEnabled() && in_array(Versionable::class, $classes) && isset($enabled) && $enabled == true) {
            $entry->enableVersioning();
        }
    }

    /**
     * Prepare the value data for update / create.
     *
     * @param  FormBuilder $builder
     * @return array
     */
    protected function prepareValueData(FormBuilder $builder)
    {
        $form = $builder->getForm();

        $entry  = $form->getEntry();
        $fields = $form->getFields();

        $allowed = $fields
            ->autoHandling()
            ->enabled()
            ->savable();

        /*
         * Set initial data from the
         * entry, minus undesired data.
         */
        $data = array_diff_key(
            $entry->getUnguardedAttributes(),
            ['id', 'created_at', 'created_by_id', 'updated_at', 'updated_by_id']
        );

        /**
         * Save default translation input.
         *
         * @var FieldType $field
         */
        foreach ($allowed->notTranslatable() as $field) {
            if (!$field->getLocale()) {
                array_set($data, str_replace('__', '.', $field->getField()), $form->getValue($field->getInputName()));
            }
        }

        /*
         * Loop through available translations
         * and save translated input.
         *
         * @var FieldType $field
         */
        if ($entry->isTranslatable()) {
            foreach (config('streams::locales.enabled') as $locale) {
                foreach ($allowed->translatable() as $field) {
                    if ($field->getLocale() == $locale) {

                        array_pull($data, $field->getField());

                        array_set(
                            $data,
                            $field->getField() . '->' . $locale,
                            $form->getValue($field->getInputName())
                        );
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Process fields that handle themselves.
     *
     * @param FormBuilder $builder
     */
    protected function processSelfHandlingFields(FormBuilder $builder)
    {
        $form = $builder->getForm();

        $entry  = $form->getEntry();
        $fields = $form->getFields();

        $fields = $fields
            ->selfHandling()
            ->writable()
            ->enabled();

        /* @var FieldType $field */
        foreach ($fields as $field) {
            app()->call([$field->setEntry($entry), 'handle'], compact('builder'));
        }
    }
}
