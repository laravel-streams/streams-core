<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
 */
class StreamModel extends EloquentModel implements StreamInterface
{

    /**
     * The cache minutes.
     *
     * @var int
     */
    //protected $cacheMinutes = 99999;

    /**
     * The foreign key for translations.
     *
     * @var string
     */
    protected $translationForeignKey = 'stream_id';

    /**
     * The translation model.
     *
     * @var string
     */
    protected $translationModel = 'Anomaly\Streams\Platform\Stream\StreamModelTranslation';

    /**
     * The model's database table name.
     *
     * @var string
     */
    protected $table = 'streams_streams';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app('Anomaly\Streams\Platform\Stream\StreamObserver'));

        parent::boot();
    }

    /**
     * Compile the entry models.
     *
     * @return mixed
     */
    public function compile()
    {
        $this->save(); // Saving triggers the observer compile event.
    }

    /**
     * Because the stream record holds translatable data
     * we have a conflict. The streams table has translations
     * but not all streams are translatable. This helps avoid
     * the translatable conflict during specific procedures.
     *
     * @param  array $attributes
     * @return static
     */
    public static function create(array $attributes)
    {
        $model = parent::create($attributes);

        $model->saveTranslations();

        return;
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
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
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
     * Get the related assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments()
    {
        return $this->assignments;
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
     * @param                $fieldSlug
     * @param EntryInterface $entry
     * @param null|string    $locale
     * @return mixed
     */
    public function getFieldType($fieldSlug, EntryInterface $entry = null, $locale = null)
    {
        if (!$assignment = $this->getAssignment($fieldSlug)) {
            return null;
        }

        return $assignment->getFieldType($entry, $locale);
    }

    /**
     * Serialize the view options before setting them on the model.
     *
     * @param $viewOptions
     */
    public function setViewOptionsAttribute($viewOptions)
    {
        $this->attributes['view_options'] = serialize($viewOptions);
    }

    /**
     * Unserialize the view options after getting them off the model.
     *
     * @param  $viewOptions
     * @return mixed
     */
    public function getViewOptionsAttribute($viewOptions)
    {
        return unserialize($viewOptions);
    }

    /**
     * Get the entry table name.
     *
     * @return string
     */
    public function getEntryTableName()
    {
        return $this->getPrefix() . $this->getSlug();
    }

    /**
     * Get the entry translations table name.
     *
     * @return string
     */
    public function getEntryTranslationsTableName()
    {
        return $this->getEntryTableName() . '_translations';
    }

    /**
     * Get the entry model.
     *
     * @return EntryModel
     */
    public function getEntryModel()
    {
        $slug      = camel_case($this->getSlug());
        $namespace = camel_case($this->getNamespace());

        $model = "Anomaly\\Streams\\Platform\\Model\\{$namespace}\\{$namespace}{$slug}EntryModel";

        return new $model;
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
     * Return the assignments relation.
     *
     * @return mixed
     */
    public function assignments()
    {
        return $this->hasMany(
            'Anomaly\Streams\Platform\Assignment\AssignmentModel',
            'stream_id'
        )->orderBy('sort_order');
    }
}
