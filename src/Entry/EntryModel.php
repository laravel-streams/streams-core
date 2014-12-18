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
use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryingEvent;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class EntryModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryModel extends EloquentModel implements EntryInterface, TableModelInterface, FormModelInterface
{

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

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        self::observe(new EntryObserver());
    }

    /**
     * Set entry information that every record needs.
     *
     * @return EntryInterface
     */
    public function touchMeta()
    {
        $userId = null;

        if ($user = app('auth')->user()) {
            $userId = $user->getKey();
        }

        if (!$this->exists) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = $userId;
            $this->updated_at = null;
            $this->sort_order = $this->count('id') + 1;
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = $userId;
        }

        return $this;
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
     * @param      $fieldSlug
     * @param null $locale
     * @param bool $mutate
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null, $mutate = true)
    {
        $locale = $locale ? : config('app.locale');

        if ($this->isTranslatable() && $translation = $this->translate($locale, false)) {

            return $translation->getAttribute($fieldSlug, false);
        }

        return $this->getAttribute($fieldSlug, false);
    }

    /**
     * Set a given attribute on the model.
     *
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @param  mixed  $value
     * @param bool    $mutate
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
     * @param bool    $mutate
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
     * @param $slug
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
     * Get an assignment by field slug.
     *
     * @param $fieldSlug
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
     * @param $fieldSlug
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
     * @param TableBuilder $builder
     * @return mixed
     */
    public function getTableEntries(TableBuilder $builder)
    {
        $table = $builder->getTable();

        // Start a new query.
        $query = $this->newQuery();

        /**
         * Prevent joins from overriding intended columns
         * by prefixing with the model's table name.
         */
        $query = $query->select($this->getTable() . '.*');

        /**
         * Eager load any relations to
         * save resources and queries.
         */
        $query = $query->with($table->getEager());

        /**
         * Raise and dispatch an event here to allow
         * other things (including filters / views)
         * to modify the query before proceeding.
         */
        app('events')->fire('streams::table.querying', new TableQueryingEvent($builder, $query));

        /**
         * Before we actually adjust the baseline query
         * set the total amount of entries possible back
         * on the table so it can be used later.
         */
        $table->setTotal($total = $query->count());

        /**
         * Assure that our page exists. If the page does
         * not exist then start walking backwards until
         * we find a page that is has something to show us.
         */
        $limit  = $table->getLimit();
        $page   = app('request')->get('page', 1);
        $offset = $limit * ($page - 1);

        if ($total < $offset && $page > 1) {
            $url = str_replace('page=' . $page, 'page=' . ($page - 1), app('request')->fullUrl());

            header('Location: ' . $url);
        }

        /**
         * Limit the results to the limit and offset
         * based on the page if any.
         */
        $limit  = $table->getLimit();
        $offset = $limit * (app('request')->get('page', 1) - 1);

        $query = $query->take($limit)->offset($offset);

        /**
         * Order the query results.
         */
        foreach ($table->getOrderBy() as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        return $query->get();
    }

    /**
     * @param Form $form
     */
    public static function saveFormInput(Form $form)
    {
        $entry = $form->getEntry();

        foreach ($form->pullInput(config('app.locale'), []) as $key => $value) {
            $entry->{$key} = $value;
        }

        $entry->save();

        if ($entry->isTranslatable()) {
            foreach (config('streams::config.available_locales') as $locale) {
                if ($locale == config('app.locale')) {
                    continue;
                }

                $entry = $entry->translate($locale);

                foreach ($form->pullInput($locale, []) as $key => $value) {
                    $entry->{$key} = $value;
                }

                $entry->save();
            }
        }
    }
}
