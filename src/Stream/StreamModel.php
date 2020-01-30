<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Support\Presenter;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\Traits\Versionable;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeQuery;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Presenter\Contract\PresentableInterface;

/**
 * Class StreamModel
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamModel extends EloquentModel implements StreamInterface, PresentableInterface
{

    use Versionable;

    /**
     * Don't cache this model.
     *
     * @var int
     */
    protected $ttl = false;

    /**
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [
        'name',
        'description',
    ];

    protected $with = [
        'assignments'
    ];

    /**
     * Attribute casts.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'array',
        'config' => 'array',
        'description' => 'array',
        'locked' => 'boolean',
        'hidden' => 'boolean',
        'sortable' => 'boolean',
        'trashable' => 'boolean',
        'translatable' => 'boolean',
    ];

    /**
     * The model's database table name.
     *
     * @var string
     */
    protected $table = 'streams_streams';

    /**
     * The streams store.
     *
     * @var StreamStore
     */
    protected static $store;

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::$store = app('Anomaly\Streams\Platform\Stream\StreamStore');

        parent::boot();
    }

    /**
     * Fire field type events.
     *
     * @param       $trigger
     * @param array $payload
     */
    public function fireFieldTypeEvents($trigger, $payload = [])
    {
        $assignments = $this->getAssignments();

        /* @var AssignmentInterface $assignment */
        foreach ($assignments->notTranslatable() as $assignment) {
            $fieldType = $assignment->getFieldType();

            $payload['stream']    = $this;
            $payload['fieldType'] = $fieldType;

            $fieldType->fire($trigger, $payload);
        }
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
     * Get the namespace.
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the config.
     *
     * @param  null $key
     * @param  null $default
     * @return mixed
     */
    public function getConfig($key = null, $default = null)
    {
        $this->cache['cache'] = $this->config;

        if ($key) {
            return array_get($this->config, $key, $default);
        }

        return $this->config;
    }

    /**
     * Merge configuration.
     *
     * @param  array $config
     * @return $this
     */
    public function mergeConfig(array $config)
    {
        $this->config = array_merge((array) $this->config, $config);

        return $this;
    }

    /**
     * Get the locked flag.
     *
     * @return bool
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * Get the hidden flag.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Get the sortable flag.
     *
     * @return bool
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * Get the searchable flag.
     *
     * @return bool
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * Get the trashable flag.
     *
     * @return bool
     */
    public function isTrashable()
    {
        return $this->trashable;
    }

    /**
     * Get the versionable flag.
     *
     * @return bool
     */
    public function isVersionable()
    {
        return $this->versionable;
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return $this->translatable;
    }

    /**
     * Get the title column.
     *
     * @return mixed
     */
    public function getTitleColumn()
    {
        return $this->title_column;
    }

    /**
     * Get the title field.
     *
     * @return null|FieldInterface
     */
    public function getTitleField()
    {
        return $this->getField($this->getTitleColumn());
    }

    /**
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * Get the field slugs for assigned fields.
     *
     * @param  null $prefix
     * @return array
     */
    public function getAssignmentFieldSlugs($prefix = null)
    {
        $assignments = $this->getAssignments();

        return $assignments->fieldSlugs($prefix);
    }

    /**
     * Get the related date assignments.
     *
     * @return AssignmentCollection
     */
    public function getDateAssignments()
    {
        $assignments = $this->getAssignments();

        return $assignments->dates();
    }

    /**
     * Get the unique translatable assignments.
     *
     * @return AssignmentCollection
     */
    public function getUniqueAssignments()
    {
        $assignments = $this->getAssignments();

        return $assignments->indexed();
    }

    /**
     * Get the only required assignments.
     *
     * @return AssignmentCollection
     */
    public function getRequiredAssignments()
    {
        $assignments = $this->getAssignments();

        return $assignments->required();
    }

    /**
     * Get the related locked assignments.
     *
     * @return AssignmentCollection
     */
    public function getLockedAssignments()
    {
        $assignments = $this->getAssignments();

        return $assignments->locked();
    }

    /**
     * Get the related unlocked assignments.
     *
     * @return AssignmentCollection
     */
    public function getUnlockedAssignments()
    {
        $assignments = $this->getAssignments();

        return $assignments->unlocked();
    }

    /**
     * Get the related translatable assignments.
     *
     * @return AssignmentCollection
     */
    public function getTranslatableAssignments()
    {
        $assignments = $this->getAssignments();

        return $assignments->translatable();
    }

    /**
     * Get the related relationship assignments.
     *
     * @return AssignmentCollection
     */
    public function getRelationshipAssignments()
    {
        $assignments = $this->getAssignments();

        return $assignments->relations();
    }

    /**
     * Get an assignment by it's field's slug.
     *
     * @param  $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug)
    {
        return $this->getAssignments()->findByFieldSlug($fieldSlug);
    }

    /**
     * Return whether a stream
     * has a field assigned.
     *
     * @param $fieldSlug
     * @return bool
     */
    public function hasAssignment($fieldSlug)
    {
        return (bool) $this->getAssignment($fieldSlug);
    }

    /**
     * Get a stream field by it's slug.
     *
     * @param  $slug
     * @return mixed
     */
    public function getField($slug)
    {
        if (!$assignment = $this->getAssignment($slug)) {
            return null;
        }

        return $assignment->getField();
    }

    /**
     * Get a field's type by the field's slug.
     *
     * @param                 $fieldSlug
     * @param  EntryInterface $entry
     * @param  null|string $locale
     * @return FieldType
     */
    public function getFieldType($fieldSlug, EntryInterface $entry = null, $locale = null)
    {
        if (!$assignment = $this->getAssignment($fieldSlug)) {
            return null;
        }

        return $assignment->getFieldType($entry, $locale);
    }

    /**
     * Get a field's query utility by the field's slug.
     *
     * @param                 $fieldSlug
     * @param  EntryInterface $entry
     * @param  null|string $locale
     * @return FieldTypeQuery
     */
    public function getFieldTypeQuery($fieldSlug, EntryInterface $entry = null, $locale = null)
    {
        if (!$fieldType = $this->getFieldType($fieldSlug, $entry, $locale)) {
            return null;
        }

        return $fieldType->getQuery();
    }

    /**
     * Get the entry table name.
     *
     * @return string
     */
    public function getEntryTableName()
    {
        return $this->getNamespace() . '_' . $this->getSlug();
    }

    /**
     * Get the entry model.
     *
     * @return EntryModel
     */
    public function getEntryModel()
    {
        return app($this->getEntryModelName());
    }

    /**
     * Get the entry name.
     *
     * @return EntryModel
     */
    public function getEntryModelName()
    {
        $slug      = ucfirst(camel_case($this->getSlug()));
        $namespace = ucfirst(camel_case($this->getNamespace()));

        return "Anomaly\\Streams\\Platform\\Model\\{$namespace}\\{$namespace}{$slug}EntryModel";
    }

    /**
     * Get the foreign key.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return str_singular($this->getSlug()) . '_id';
    }

    /**
     * Return a created presenter.
     *
     * @return Presenter
     */
    public function getPresenter()
    {
        return new StreamPresenter($this);
    }

    /**
     * Return the assignments relation.
     *
     * @return mixed
     */
    public function assignments()
    {
        return $this->hasMany(
            AssignmentModel::class,
            'stream_id'
        )->orderBy('sort_order');
    }
}
