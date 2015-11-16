<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Assignment\AssignmentModelTranslation;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryObserver;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Field\FieldModelTranslation;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Command\CompileStream;
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
    protected $cacheMinutes = 99999;

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
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [
        'name',
        'description'
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
     * Make a Stream instance from the provided compile data.
     *
     * @param  array $data
     * @return StreamInterface
     */
    public function make(array $data)
    {
        $payload = $data;

        if ($stream = self::$store->get($data)) {
            return $stream;
        }

        $assignments = array();

        $streamModel        = new StreamModel();
        $streamTranslations = new EloquentCollection();

        $data['config'] = serialize(array_get($data, 'config', []));

        if ($translations = array_pull($data, 'translations')) {
            foreach ($translations as $attributes) {

                $translation = new StreamModelTranslation();
                $translation->setRawAttributes($attributes);

                $streamTranslations->push($translation);
            }
        }

        $streamModel->setRawAttributes($data);

        $streamModel->setRelation('translations', $streamTranslations);

        unset($this->translations);

        if (array_key_exists('assignments', $data)) {

            foreach ($data['assignments'] as $assignment) {

                if (isset($assignment['field'])) {

                    $assignment['field']['config'] = unserialize($assignment['field']['config']);

                    $fieldModel        = new FieldModel();
                    $fieldTranslations = new EloquentCollection();

                    if (isset($assignment['field']['translations'])) {
                        foreach (array_pull($assignment['field'], 'translations') as $attributes) {

                            $translation = new FieldModelTranslation();
                            $translation->setRawAttributes($attributes);

                            $fieldTranslations->push($translation);
                        }
                    }

                    $assignment['field']['config'] = serialize($assignment['field']['config']);

                    $fieldModel->setRawAttributes($assignment['field']);

                    $fieldModel->setRelation('translations', $fieldTranslations);

                    unset($assignment['field']);

                    $assignmentModel        = new AssignmentModel();
                    $assignmentTranslations = new EloquentCollection();

                    if (isset($assignment['translations'])) {
                        foreach (array_pull($assignment, 'translations') as $attributes) {

                            $translation = new AssignmentModelTranslation();
                            $translation->setRawAttributes($attributes);

                            $assignmentTranslations->push($translation);
                        }
                    }

                    $assignmentModel->setRawAttributes($assignment);
                    $assignmentModel->setRawAttributes($assignment);

                    $assignmentModel->setRelation('field', $fieldModel);
                    $assignmentModel->setRelation('stream', $streamModel);
                    $assignmentModel->setRelation('translations', $assignmentTranslations);

                    $assignments[] = $assignmentModel;
                }
            }
        }

        $assignmentsCollection = new AssignmentCollection($assignments);

        $streamModel->setRelation('assignments', $assignmentsCollection);

        $streamModel->assignments = $assignmentsCollection;

        self::$store->put($payload, $streamModel);

        $entryModel = $streamModel->getEntryModel();

        $entryModel::observe(EntryObserver::class);

        return $streamModel;
    }

    /**
     * Compile the entry models.
     *
     * @return mixed
     */
    public function compile()
    {
        $this->dispatch(new CompileStream($this));
    }

    /**
     * Flush the entry stream's cache.
     *
     * @return StreamInterface
     */
    public function flushCache()
    {
        (new CacheCollection())->setKey($this->getCacheCollectionKey())->flush();
        (new CacheCollection())->setKey((new FieldModel())->getCacheCollectionKey())->flush();
        (new CacheCollection())->setKey((new AssignmentModel())->getCacheCollectionKey())->flush();

        return $this;
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
    public static function create(array $attributes = [])
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
     * Get the view options.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
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
     * Get the trashable flag.
     *
     * @return bool
     */
    public function isTrashable()
    {
        return $this->trashable;
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
     * @return array
     */
    public function getAssignmentFieldSlugs()
    {
        $assignments = $this->getAssignments();

        return $assignments->fieldSlugs();
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
    public function setConfigAttribute($viewOptions)
    {
        $this->attributes['config'] = serialize($viewOptions);
    }

    /**
     * Unserialize the view options.
     *
     * @param  $viewOptions
     * @return mixed
     */
    public function getConfigAttribute($viewOptions)
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
