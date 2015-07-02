<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryTranslationsModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryTranslationsModel extends EloquentModel
{

    /**
     * The stream model.
     *
     * @var null|StreamInterface
     */
    protected $stream = null;

    /**
     * The parent model.
     *
     * @var null|EntryInterface
     */
    protected $parent = null;

    /**
     * Cache minutes.
     *
     * @var int
     */
    protected $cacheMinutes = 99999;

    /**
     * Create a new EntryTranslationsModel instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        /* @var EntryInterface $model */
        $model = str_replace('TranslationsModel', 'Model', get_class($this));

        $this->parent = new $model;

        $this->stream = $this->parent->getStream();

        parent::__construct($attributes);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app(substr(__CLASS__, 0, -5) . 'Observer'));

        parent::boot();
    }

    /**
     * Get an attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $assignment = $this->parent->getAssignment($key);

        if (!$assignment) {
            return parent::getAttribute($key);
        }

        $type = $assignment->getFieldType($this);

        $type->setEntry($this);
        $type->setLocale($this->locale);

        $accessor = $type->getAccessor();
        $modifier = $type->getModifier();

        return $modifier->restore($accessor->get($key));
    }

    /**
     * Set the attribute.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setAttribute($key, $value)
    {
        $assignment = $this->parent->getAssignment($key);

        if (!$assignment) {

            parent::setAttribute($key, $value);

            return;
        }

        $type = $assignment->getFieldType($this);

        $type->setEntry($this);
        $type->setLocale($this->locale);

        $accessor = $type->getAccessor();
        $modifier = $type->getModifier();

        $accessor->set($modifier->modify($value));
    }
}
