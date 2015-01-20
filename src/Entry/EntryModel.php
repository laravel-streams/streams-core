<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\Contract\DateFieldTypeInterface;
use Anomaly\Streams\Platform\Addon\FieldType\Contract\RelationFieldTypeInterface;
use Anomaly\Streams\Platform\Addon\FieldType\Contract\SetterFieldTypeInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormModelInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Dimsav\Translatable\Translatable;
use Illuminate\Events\Dispatcher;

/**
 * Class EntryModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryModel extends EloquentModel implements EntryInterface, FormModelInterface
{

    use Translatable;

    /**
     * Validation rules. These are overridden
     * on the compiled models.
     *
     * @var array
     */
    public $rules = [];

    /**
     * The compiled stream data.
     *
     * @var array|StreamInterface
     */
    protected $stream = [];

    /**
     * Create a new EntryModel instance.
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->stream = app('Anomaly\Streams\Platform\Stream\StreamModel')->make($this->stream);

        $this->stream->parent = $this;
    }

    protected static function boot()
    {
        self::observe(new EntryObserver(new Dispatcher(app()), new \Illuminate\Bus\Dispatcher(app())));

        parent::boot();
    }

    /**
     * Get the ID.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getKey();
    }

    /**
     * Get the entries title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->{$this->titleKey};
    }

    /**
     * Get validation rules.
     *
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }


    /**
     * Get an attribute value by a field slug.
     *
     * This is a pretty automated process. Let
     * the accessor method overriding Eloquent
     * take care of this whole ordeal.
     *
     * @param       $fieldSlug
     * @param  null $locale
     * @param  bool $mutate
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null, $mutate = true)
    {
        $locale = $locale ?: config('app.locale');

        if ($this->isTranslatable() && $translation = $this->translate($locale, false)) {
            return $translation->getAttribute($fieldSlug, false);
        }

        return parent::getAttribute($fieldSlug);
    }

    /**
     * Set a given attribute on the model.
     *
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @param  mixed  $value
     * @param  bool   $mutate
     * @return void
     */
    public function setAttribute($key, $value, $mutate = true)
    {
        /**
         * If we have a field type for this key use
         * it's setAttribute method to set the value.
         */
        if ($mutate && $field = $this->getField($key)) {
            $type = $field->getType();

            if ($type instanceof SetterFieldTypeInterface) {
                $type->setAttribute($this->attributes, $value);

                return;
            }

            $value = $type->mutate($value);
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Get a given attribute on the model.
     *
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @param  bool   $mutate
     * @return void
     */
    public function getAttribute($key, $mutate = true)
    {
        $value = parent::getAttribute($key);

        /**
         * If we have a field type for this key use
         * it's unmutate method to modify the value.
         */
        if ($mutate && $type = $this->getFieldType($key)) {
            return $type->unmutate($value);
        }

        return $value;
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get an entry field.
     *
     * @param  $slug
     * @return FieldInterface|null
     */
    public function getField($slug)
    {
        $assignment = $this->getAssignment($slug);

        if (!$assignment instanceof AssignmentInterface) {
            return null;
        }

        return $assignment->getField();
    }

    /**
     * Return whether the entry has a field.
     *
     * @param  $slug
     * @return bool
     */
    public function hasField($slug)
    {
        return ($this->getField($slug) instanceof FieldInterface);
    }

    /**
     * Get an assignment by field slug.
     *
     * @param  $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug)
    {
        $stream = $this->getStream();

        $assignments = $stream->getAssignments();

        return $assignments->findByFieldSlug($fieldSlug);
    }

    /**
     * Get the field type from a field slug.
     *
     * @param  $fieldSlug
     * @return FieldType|RelationFieldTypeInterface|DateFieldTypeInterface
     */
    public function getFieldType($fieldSlug)
    {
        $assignment = $this->getAssignment($fieldSlug);

        if (!$assignment instanceof AssignmentInterface) {
            return null;
        }

        return $assignment->getFieldType($this);
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return ($this->stream->isTranslatable());
    }

    /**
     * @param array $items
     * @return EntryCollection
     */
    public function newCollection(array $items = array())
    {
        return new EntryCollection($items);
    }

    /**
     * Save the form input.
     *
     * @param Form          $form
     * @param EntryHydrator $hydrator
     */
    public function saveFormInput(Form $form, EntryHydrator $hydrator)
    {
        $entry  = $form->getEntry();
        $fields = $form->getFields();

        /**
         * Save default translation input.
         */
        $hydrator->fill($entry, $fields->locale(config('app.locale')));

        $entry->save();

        /**
         * Loop through available translations
         * and save translated input.
         */
        if ($entry->isTranslatable() and $entry instanceof Translatable) {

            foreach (config('streams::config.available_locales') as $locale) {

                //  Skip default - already did it.
                if ($locale == config('app.locale')) {
                    continue;
                }

                $entry = $entry->translate($locale);

                $hydrator->fill($entry, $fields->locale($locale));

                $entry->save();
            }
        }
    }
}
