<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

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
     * Cache minutes.
     *
     * @var int
     */
    //protected $cacheMinutes = 99999;

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::observe(app(substr(__CLASS__, 0, -5) . 'Observer'));

        parent::boot();
    }

    /**
     * Get the locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->getAttributeFromArray($this->getLocaleKey());
    }

    /**
     * Get an attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if ($key === 'locale') {
            return parent::getAttribute('locale');
        }

        if (!$parent = $this->getParent()) {
            return $this->attributes[$key];
        }

        /* @var AssignmentInterface $assignment */
        $assignment = $parent->getAssignment($key);

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
     * Get the parent.
     *
     * @return EntryModel
     */
    public function getParent()
    {
        return isset($this->relations['parent']) ? $this->relations['parent'] : null;
    }

    /**
     * Set the attribute.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setAttribute($key, $value)
    {
        if (!$parent = $this->getParent()) {
            return null;
        }

        /* @var AssignmentInterface $assignment */
        $assignment = $parent->getAssignment($key);

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

    /**
     * Fire field type events.
     *
     * @param       $trigger
     * @param array $payload
     */
    public function fireFieldTypeEvents($trigger, $payload = [])
    {
        if (!$parent = $this->getParent()) {
            return null;
        }

        $assignments = $parent->getAssignments();

        /* @var AssignmentInterface $assignment */
        foreach ($assignments->translatable() as $assignment) {

            $fieldType = $assignment->getFieldType();

            $fieldType->setValue($parent->getFieldValue($assignment->getFieldSlug()));

            $fieldType->setEntry($this);
            $fieldType->setLocale($this->locale);

            $fieldType->fire($trigger, array_merge(compact('fieldType', 'entry'), $payload));
        }
    }

    /**
     * Let the parent handle calls if they don't exist here.
     *
     * @param string $name
     * @param array  $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        return call_user_func_array([$this->getParent(), $name], $arguments);
    }
}
