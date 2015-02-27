<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Events\Dispatcher;
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
        return $this->{$this->getTitleKey()};
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

        $handler  = $type->getHandler();
        $modifier = $type->getModifier();

        if ($assignment->isTranslatable()) {
            $entry = $this->translateOrNew($locale);
        } else {
            $entry = $this;
        }

        return $modifier->restore($handler->get($entry, $fieldSlug));
    }

    /**
     * Get a field type presenter.
     *
     * @param $fieldSlug
     * @return FieldTypePresenter
     */
    public function getFieldPresenter($fieldSlug)
    {
        $assignment = $this->getAssignment($fieldSlug);

        $type = $assignment->getFieldType($this);

        $handler  = $type->getHandler();
        $modifier = $type->getModifier();

        return $type->setValue($modifier->restore($handler->get($this, $fieldSlug)));
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

        $handler  = $type->getHandler();
        $modifier = $type->getModifier();

        $handler->set($this, $modifier->modify($value));
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
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
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

        if (!is_object($stream)) {
            return false;
        }

        $assignments = $stream->getAssignments();

        return $assignments->findByFieldSlug($fieldSlug);
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
     * Return whether or not the assignment for
     * the given field slug is translatable.
     *
     * @param $fieldSlug
     * @return bool
     */
    public function assignmentIsTranslatable($fieldSlug)
    {
        // ID is not. Duh!
        if ($fieldSlug == 'id') {
            return false;
        }

        $assignment = $this->getAssignment($fieldSlug);

        return $assignment->isTranslatable();
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
     * Return the entry presenter.
     *
     * @return EntryPresenter
     */
    public function getPresenter()
    {
        return new EntryPresenter($this);
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getStream()->getAssignments()->translatable()->fieldSlugs() AS $field) {
            if ($translations = $this->getTranslation()) {
                $attributes[$field] = $translations->$field;
            }
        }

        return $attributes;
    }
}
