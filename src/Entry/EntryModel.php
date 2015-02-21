<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
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
     * Get validation rules.
     *
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }


    /**
     * Get a field value.
     *
     * @param       $fieldSlug
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $decorate = false)
    {
        $assignment = $this->getAssignment($fieldSlug);

        $type = $assignment->getFieldType($this);

        $handler  = $type->getHandler();
        $modifier = $type->getModifier();

        $value = $modifier->restore($handler->get($this, $fieldSlug));

        if (!$decorate) {
            return $value;
        }

        $type->setValue($value);

        return $type->getPresenter();
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
        if (!$this->hasSetMutator($key) && $this->getFieldType($key, $value)) {
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
        if (!$this->hasGetMutator($key) && $this->getFieldType($key)) {
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
     * Return the entry presenter.
     *
     * @return EntryPresenter
     */
    public function getPresenter()
    {
        return new EntryPresenter($this);
    }
}
