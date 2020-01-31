<?php

namespace Anomaly\Streams\Platform\Entry;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use Laravel\Scout\ModelObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Stream\StreamStore;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\Traits\Versionable;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeQuery;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Presenter\Contract\PresentableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EntryModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryModel extends EloquentModel implements EntryInterface, PresentableInterface
{
    use Searchable;
    use Versionable;
    use SoftDeletes;

    /**
     * The stream definition.
     *
     * @var array
     */
    protected static $stream = [];

    /**
     * Enable timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The searchable flag.
     *
     * @var boolean
     */
    protected $searchable = false;

    /**
     * The field slugs.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * The entry relationships by field slug.
     *
     * @var array
     */
    protected $relationships = [];

    /**
     * Hide these from toArray.
     *
     * @var array
     */
    protected $hidden = [
        'stream',
    ];

    /**
     * Date casted attributes.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        $instance = new static;

        $class     = get_class($instance);
        $events    = $instance->getObservableEvents();
        $observer  = substr($class, 0, -5) . 'Observer';
        $observing = class_exists($observer);

        if ($events && $observing) {
            self::observe(app($observer));
        }

        if (!$instance->isSearchable()) {
            ModelObserver::disableSyncingFor(get_class(new static));
        }

        if ($events && !$observing) {
            self::observe(EntryObserver::class);
        }
    }

    /**
     * Sort the query.
     *
     * @param Builder $builder
     * @param string $direction
     */
    public function scopeSorted(Builder $builder, $direction = 'asc')
    {
        $builder->orderBy('sort_order', $direction);
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
     * Get the table.
     */
    public function getTable()
    {
        if ($this->table) {
            return $this->table;
        }

        $stream = $this->stream();

        return $stream->namespace . '_' . $stream->slug;
    }

    /**
     * Get the sort order.
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * Get the entries title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->{$this->getTitleName()};
    }

    /**
     * Get a field value.
     *
     * @param        $fieldSlug
     * @param  null $locale
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null)
    {
        $assignment = $this->getAssignment($fieldSlug);

        $type = $assignment->getFieldType();

        $modifier = $type->getModifier();

        $type->setEntry($this);

        $value = parent::getAttributeValue($fieldSlug);

        if ($assignment->translatable) {
            $value = $value[$this->locale($locale)];
        }

        $value = $modifier->restore($value);

        $type->setValue($value);

        return $value;
    }

    /**
     * Set a field value.
     *
     * @param        $fieldSlug
     * @param        $value
     * @param  null $locale
     * @return $this
     */
    public function setFieldValue($fieldSlug, $value, $locale = null)
    {
        $assignment = $this->getAssignment($fieldSlug);

        $type = $assignment->getFieldType($this);

        $type->setEntry($this);

        $modifier = $type->getModifier();

        $key = $type->getColumnName();

        if ($assignment->isTranslatable()) {
            $key = $key . '->' . ($locale ?: app()->getLocale());
        }

        return parent::setAttribute($key, $modifier->modify($value));
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
     * Return whether an entry has
     * a field with a given slug.
     *
     * @param  $slug
     * @return bool
     */
    public function hasField($slug)
    {
        return ($this->getField($slug) !== null);
    }

    /**
     * Get the field type from a field slug.
     *
     * @param  $fieldSlug
     * @return null|FieldType
     */
    public function getFieldType($fieldSlug)
    {
        $locale = config('app.locale');

        $assignment = $this->stream()->assignments->findByFieldSlug($fieldSlug);

        if (!$assignment) {
            return null;
        }

        $type = $assignment->getFieldType();

        $type->setEntry($this);

        $type->setValue($this->getFieldValue($fieldSlug));
        $type->setEntry($this);

        return $type;
    }

    /**
     * Get the field type query.
     *
     * @param $fieldSlug
     * @return FieldTypeQuery
     */
    public function getFieldTypeQuery($fieldSlug)
    {
        if (!$type = $this->getFieldType($fieldSlug)) {
            return null;
        }

        return $type->getQuery();
    }

    /**
     * Get the field type presenter.
     *
     * @param $fieldSlug
     * @return FieldTypePresenter
     */
    public function getFieldTypePresenter($fieldSlug)
    {
        if (!$type = $this->getFieldType($fieldSlug)) {
            return null;
        }

        return $type->getPresenter();
    }

    /**
     * Set a given attribute on the model.
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string|null $locale
     * @return EntryModel|EloquentModel
     */
    public function setAttribute($key, $value, $locale = null)
    {
        if ($this->isTranslatedAttribute($key) && !$this->hasSetMutator($key) && $this->getFieldType($key)) {
            return $this->setFieldValue($key, $value, $locale);
        }

        return parent::setAttribute($key, $value, $locale);
    }

    /**
     * Get a given attribute on the model.
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (isset($this->attributes['id']) && isset(self::$cache[$this->getTable() . '.' . $this->attributes['id']][$key])) {
            return self::$cache[$this->getTable() . '.' . $this->attributes['id']][$key];
        }

        // Check if it's a relationship first.
        dd(array_keys(self::$stream['fields']));
        if (in_array($key, array_merge(array_keys(self::$stream['fields']), ['created_by', 'updated_by']))) {
            return parent::getAttribute(camel_case($key));
        }

        if (!$this->hasGetMutator($key) && $this->stream()->assignments->findByFieldSlug($key)) {
            return $this->getFieldValue($key);
        }

        if (isset($this->attributes['id'])) {
            return self::$cache[$this->getTable() . '.' . $this->attributes['id']][$key] = parent::getAttribute($key);
        } else {
            return parent::getAttribute($key);
        }
    }

    /**
     * Get a raw unmodified attribute.
     *
     * @param             $key
     * @param  bool $process
     * @return mixed|null
     */
    public function getRawAttribute($key, $process = true)
    {
        if (!$process) {
            return $this->getAttributeFromArray($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Set a raw unmodified attribute.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setRawAttribute($key, $value)
    {
        parent::setAttribute($key, $value);

        return $this;
    }

    /**
     * Return the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream();
    }

    /**
     * Return the stream.
     *
     * @return StreamInterface
     */
    public function stream()
    {
        return $this->getStreamAttribute();
    }

    /**
     * Get the stream ID.
     *
     * @return int
     */
    public function getStreamId()
    {
        return $this->stream()->getId();
    }

    /**
     * Get the stream namespace.
     *
     * @return string
     */
    public function getStreamNamespace()
    {
        return $this->stream()->getNamespace();
    }

    /**
     * Get the stream slug.
     *
     * @return string
     */
    public function getStreamSlug()
    {
        return $this->stream()->getSlug();
    }

    /**
     * Get the entry's stream name.
     *
     * @return string
     */
    public function getStreamName()
    {
        return $this->stream()->getName();
    }

    /**
     * Get the stream prefix.
     *
     * @return string
     */
    public function getStreamPrefix()
    {
        return $this->stream()->getPrefix();
    }

    /**
     * Get the field slugs for assigned fields.
     *
     * @param  null $prefix
     * @return array
     */
    public function getAssignmentFieldSlugs($prefix = null)
    {
        return $this->stream()->assignments->fieldSlugs($prefix);
    }

    /**
     * Get all assignments of the
     * provided field type namespace.
     *
     * @param $fieldType
     * @return AssignmentCollection
     */
    public function getAssignmentsByFieldType($fieldType)
    {
        return $this->stream()->assignments->findAllByFieldType($fieldType);
    }

    /**
     * Get an assignment by field slug.
     *
     * @param  $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug)
    {
        return $this->stream()->assignments->findByFieldSlug($fieldSlug);
    }

    /**
     * Return translated assignments.
     *
     * @return AssignmentCollection
     */
    public function getTranslatableAssignments()
    {
        return $this->stream()->assignments->translatable();
    }

    /**
     * Return pivot relation assignments.
     *
     * @return AssignmentCollection
     */
    public function getPivotRelationshipAssignments()
    {
        $relations = $this->stream()->assignments->relations();

        return $relations->filter(
            function (AssignmentInterface $assignment) {
                return $assignment->field->type->getColumnType() === false;
            }
        );
    }

    /**
     * Return required assignments.
     *
     * @return AssignmentCollection
     */
    public function getRequiredAssignments()
    {
        $stream      = $this->stream();
        $assignments = $stream->assignments;

        return $assignments->required();
    }

    /**
     * Return searchable assignments.
     *
     * @return AssignmentCollection
     */
    public function getSearchableAssignments()
    {
        $stream      = $this->stream();
        $assignments = $stream->assignments;

        return $assignments->searchable();
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return $this->stream()->isTranslatable();
    }

    /**
     * Return whether the entry is trashable or not.
     *
     * @return bool
     */
    public function isTrashable()
    {
        return $this->stream()->isTrashable();
    }

    /**
     * Return the last modified datetime.
     *
     * @return Carbon
     */
    public function lastModified()
    {
        return $this->updated_at ?: $this->created_at;
    }

    /**
     * Return the created by relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Return the updated by relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Return whether the title column is
     * translatable or not.
     *
     * @return bool
     */
    public function titleColumnIsTranslatable()
    {
        return $this->assignmentIsTranslatable($this->getTitleName());
    }

    /**
     * Return whether or not the assignment for
     * the given field slug is translatable.
     *
     * @param $fieldSlug
     * @return bool
     */
    public function assignmentIsTranslatable($fieldSlug)
    {
        return $this->isTranslatedAttribute($fieldSlug);
    }

    /**
     * Return whether or not the assignment for
     * the given field slug is a relationship.
     *
     * @param $fieldSlug
     * @return bool
     */
    public function assignmentIsRelationship($fieldSlug)
    {
        return $this
            ->stream()
            ->assignments
            ->relations()
            ->fieldSlugs()
            ->contains($fieldSlug);
    }

    /**
     * Fire field type events.
     *
     * @param       $trigger
     * @param array $payload
     */
    public function fireFieldTypeEvents($trigger, $payload = [])
    {
        $assignments = $this->stream()->assignments;

        /* @var AssignmentInterface $assignment */
        foreach ($assignments->notTranslatable() as $assignment) {
            $fieldType = $assignment->getFieldType();

            $fieldType->setValue($this->getRawAttribute($assignment->field->slug));

            $fieldType->setEntry($this);

            $payload['entry']     = $this;
            $payload['fieldType'] = $fieldType;

            $fieldType->fire($trigger, $payload);
        }
    }

    /**
     * Return the related stream.
     *
     * @return StreamInterface|array
     */
    public function getStreamAttribute()
    {
        if (!$this->stream instanceof StreamInterface) {

            [$namespace, $slug] = explode('.', $this->stream);

            $this->stream = app(StreamModel::class)
                ->whereNamespace($namespace)
                ->whereSlug($slug)
                ->first();
        }

        return $this->stream;
    }

    /**
     * @param  array $items
     * @return EntryCollection
     */
    public function newCollection(array $items = [])
    {
        $collection = substr(get_class($this), 0, -5) . 'Collection';

        if (class_exists($collection)) {
            return new $collection($items);
        }

        return new EntryCollection($items);
    }

    /**
     * Return the entry presenter.
     *
     * This is against standards but required
     * by the presentable interface.
     *
     * @return EntryPresenter
     */
    public function getPresenter()
    {
        $presenter = substr(get_class($this), 0, -5) . 'Presenter';

        if (class_exists($presenter)) {
            return app()->make($presenter, ['object' => $this]);
        }

        return new EntryPresenter($this);
    }

    /**
     * Return a new presenter instance.
     *
     * @return EntryPresenter
     */
    public function newPresenter()
    {
        return $this->getPresenter();
    }

    /**
     * Return a model route.
     *
     * @param       $route The route name you would like to return a URL for (i.e. "view" or "delete")
     * @param array $parameters
     * @return string
     */
    public function route($route, array $parameters = [])
    {
        $router = $this->getRouter();

        return $router->make($route, $parameters);
    }

    /**
     * Return a new router instance.
     *
     * @return EntryRouter
     */
    public function newRouter()
    {
        return app()->make($this->getRouterName(), ['entry' => $this]);
    }

    /**
     * Get the router.
     *
     * @return EntryRouter
     */
    public function getRouter()
    {
        if (isset($this->cache['router'])) {
            return $this->cache['router'];
        }

        return $this->cache['router'] = $this->newRouter();
    }

    /**
     * Get the router name.
     *
     * @return string
     */
    public function getRouterName()
    {
        $router = substr(get_class($this), 0, -5) . 'Router';

        return class_exists($router) ? $router : EntryRouter::class;
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        $builder = $this->getQueryBuilderName();

        return new $builder($query);
    }

    /**
     * Get the router name.
     *
     * @return string
     */
    public function getQueryBuilderName()
    {
        $builder = substr(get_class($this), 0, -5) . 'QueryBuilder';

        return class_exists($builder) ? $builder : EntryQueryBuilder::class;
    }

    /**
     * Get the criteria class.
     *
     * @return string
     */
    public function getCriteriaName()
    {
        $criteria = substr(get_class($this), 0, -5) . 'Criteria';

        return class_exists($criteria) ? $criteria : EntryCriteria::class;
    }

    /**
     * Return whether the model is searchable or not.
     *
     * @return boolean
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * Hook into the casts data.
     */
    public function getCasts()
    {
        $casts = parent::getCasts();

        /**
         * Translated fields are always array.
         */
        $translated = $this->stream()->assignments->translatable()->fieldSlugs();

        if ($translated->isNotEmpty()) {
            $casts = array_merge(array_combine($translated->all(), array_fill(0, $translated->count(), 'array')), $casts);
        }

        /**
         * Add dates.
         * 
         * @todo this needs to be wrapped up into the field types.
         */
        $dates = $this->stream()->assignments->dates();

        if ($dates->isNotEmpty()) {
            $casts = array_merge(array_combine($dates->fieldSlugs()->all(), $dates->map(function ($assignment) {
                return $assignment->field->type->getColumnType();
            })->all()), $casts);
        }

        return array_merge($casts, [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ], (array) $this->stream->assignments->translatable());
    }

    /**
     * Return a searchable array.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->getId(),
        ];

        $searchable = array_merge(
            $this->searchableAttributes,
            $this
                ->stream()
                ->assignments
                ->searchable()
                ->fieldSlugs()
                ->all()
        );

        if (!$searchable) {
            $searchable = $this
                ->stream()
                ->assignments
                ->fieldSlugs()
                ->all();
        }

        foreach ($searchable as $field) {
            if (!in_array($field, $searchable)) {
                continue;
            }

            $array[$field] = (string) $this
                ->getFieldType($field)
                ->getSearchableValue();
        }

        return $array;
    }

    /**
     * Return the object as an
     * array for comparison.
     *
     * @return array
     */
    public function toArrayForComparison()
    {
        $array = array_diff_key(
            $this->toArrayWithRelations(),
            array_flip($this->getNonVersionedAttributes())
        );

        /* @var AssignmentInterface $assignment */
        foreach ($this->stream()->assignments->relations() as $assignment) {

            $related = $this->{$assignment->field->slug};

            $type = $assignment->getFieldType();

            if (!method_exists($type, 'toArrayForComparison') && !$type->hasHook('to_array_for_comparison')) {
                continue;
            }

            if ($related instanceof Collection) {

                /* @var EloquentModel $entry */
                $array[$assignment->field->slug] = app()->call(
                    [$type, 'toArrayForComparison'],
                    ['related' => $related]
                );
            }

            if ($related instanceof EntryModel) {
                $array[$assignment->field->slug] = app()->call(
                    [$type, 'toArrayForComparison'],
                    ['related' => $related]
                );
            }
        }

        array_walk(
            $array,
            function ($value, $key) use (&$array) {

                /**
                 * Make sure any nested arrays are serialized.
                 */
                if (is_array($value)) {
                    $array[$key] = json_encode($value);
                }
            }
        );

        return $array;
    }

    /**
     * Override the __get method.
     *
     * @param  string $key
     * @return EntryPresenter|mixed
     */
    public function __get($key)
    {
        if ($key === 'decorate') {
            return $this->getPresenter();
        }

        return parent::__get($key); // TODO: Change the autogenerated stub
    }

    /**
     * Clean up the object before serializing.
     *
     * @return array
     */
    public function __sleep()
    {
        $variables = parent::__sleep();

        $variables = array_diff(
            $variables,
            [
                'stream',
            ]
        );

        return $variables;
    }
}
