<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\AssignmentCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Robbo\Presenter\PresentableInterface;

/**
 * Class EntryModel
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryModel extends EloquentModel implements EntryInterface, PresentableInterface
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
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app(substr(__CLASS__, 0, -5) . 'Observer'));

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
        return $this->{$this->getTitleName()};
    }

    /**
     * Get a field value.
     *
     * @param      $fieldSlug
     * @param null $locale
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null)
    {
        if (!$locale) {
            $locale = config('app.locale');
        }

        $assignment = $this->getAssignment($fieldSlug);

        $type = $assignment->getFieldType($this);

        $accessor = $type->getAccessor();
        $modifier = $type->getModifier();

        if ($assignment->isTranslatable()) {
            $entry = $this->translateOrDefault($locale);
        } else {
            $entry = $this;
        }

        $type->setEntry($entry);

        return $modifier->restore($accessor->get($fieldSlug));
    }

    /**
     * Set a field value.
     *
     * @param $fieldSlug
     * @param $value
     */
    public function setFieldValue($fieldSlug, $value)
    {
        $assignment = $this->getAssignment($fieldSlug);

        $type = $assignment->getFieldType($this);

        $type->setEntry($this);

        $accessor = $type->getAccessor();
        $modifier = $type->getModifier();

        $accessor->set($modifier->modify($value));
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
        $assignment = $this->getAssignment($fieldSlug);

        if (!$assignment instanceof AssignmentInterface) {
            return null;
        }

        $type = $assignment->getFieldType($this);

        $type->setValue($this->getFieldValue($fieldSlug));
        $type->setEntry($this);

        return $type;
    }

    /**
     * Get the rules for a field.
     *
     * @param  $fieldSlug
     * @return array
     */
    public function getFieldRules($fieldSlug)
    {
        $field = $this->getField($fieldSlug);

        return $field->getRules();
    }

    /**
     * Set a given attribute on the model.
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if (!$this->isKeyALocale($key) && !$this->hasSetMutator($key) && $this->getFieldType($key, $value)) {
            $this->setFieldValue($key, $value);
        } else {
            parent::setAttribute($key, $value);
        }
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
        if (
            !$this->hasGetMutator($key)
            && !in_array($key, [$this->relations])
            && !method_exists($this, $key)
            && $this->getFieldType($key)
        ) {
            return $this->getFieldValue($key);
        } else {
            return parent::getAttribute($key);
        }
    }

    /**
     * Get a raw unmodified attribute.
     *
     * @param $key
     * @return mixed|null
     */
    public function getRawAttribute($key)
    {
        return parent::getAttribute($key);
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream();
    }

    /**
     * Get the stream namespace.
     *
     * @return string
     */
    public function getStreamNamespace()
    {
        $stream = $this->getStream();

        return $stream->getNamespace();
    }

    /**
     * Get the stream slug.
     *
     * @return string
     */
    public function getStreamSlug()
    {
        $stream = $this->getStream();

        return $stream->getSlug();
    }

    /**
     * Get the stream prefix.
     *
     * @return string
     */
    public function getStreamPrefix()
    {
        $stream = $this->getStream();

        return $stream->getPrefix();
    }

    /**
     * Get the table name.
     *
     * @return string
     */
    public function getTableName()
    {
        $stream = $this->getStream();

        return $stream->getEntryTableName();
    }

    /**
     * Get the translations table name.
     *
     * @return string
     */
    public function getTranslationsTableName()
    {
        $stream = $this->getStream();

        return $stream->getEntryTranslationsTableName();
    }

    /**
     * Get all assignments.
     *
     * @return AssignmentCollection
     */
    public function getAssignments()
    {
        $stream = $this->getStream();

        return $stream->getAssignments();
    }

    /**
     * Get an assignment by field slug.
     *
     * @param  $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug)
    {
        $assignments = $this->getAssignments();

        return $assignments->findByFieldSlug($fieldSlug);
    }

    /**
     * Return translated assignments.
     *
     * @return AssignmentCollection
     */
    public function getTranslatableAssignments()
    {
        $stream      = $this->getStream();
        $assignments = $stream->getAssignments();

        return $assignments->translatable();
    }

    /**
     * Return relation assignments.
     *
     * @return AssignmentCollection
     */
    public function getRelationshipAssignments()
    {
        $stream      = $this->getStream();
        $assignments = $stream->getAssignments();

        return $assignments->relations();
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        $stream = $this->getStream();

        return $stream->isTranslatable();
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
        $relationships = $this->getRelationshipAssignments();

        return in_array($fieldSlug, $relationships->fieldSlugs());
    }

    /**
     * Fire field type events.
     *
     * @param       $trigger
     * @param array $payload
     */
    public function fireFieldTypeEvents($trigger, $payload = [])
    {
        /* @var AssignmentInterface $assignment */
        foreach ($this->getAssignments() as $assignment) {

            $fieldType = $assignment->getFieldType();

            $fieldType->setValue($this->getFieldValue($assignment->getFieldSlug()));

            $fieldType->setEntry($this);

            $fieldType->fire($trigger, array_merge(compact('fieldType', 'entry'), $payload));
        }
    }

    /**
     * Return the related stream.
     *
     * @return StreamInterface|array
     */
    public function stream()
    {
        if (!$this->stream instanceof StreamInterface) {
            $this->stream = app('Anomaly\Streams\Platform\Stream\StreamModel')->make($this->stream);
        }

        return $this->stream;
    }

    /**
     * @param array $items
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
}
