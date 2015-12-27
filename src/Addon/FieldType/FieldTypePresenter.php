<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\AddonPresenter;

/**
 * Class FieldTypePresenter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypePresenter extends AddonPresenter
{

    /**
     * The resource object.
     * This is for IDE hinting.
     *
     * @var FieldType
     */
    protected $object;

    /**
     * Get the object.
     *
     * @return FieldType
     */
    public function getObject()
    {
        return parent::getObject();
    }

    /**
     * By default return the value.
     * This can be dangerous if used in a loop!
     * There is a PHP bug that caches it's
     * output when used in a loop.
     * Take heed.
     *
     * @return string
     */
    public function __toString()
    {
        $value = $this->object->getValue();

        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string)$this->object->getValue();
    }

    /**
     * If attempting to access a property first
     * check if the method exists and return it's
     * result before handling natively. This makes
     * a much sexier syntax for presenter methods off
     * of entry objects.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return call_user_func_array([$this, $key], []);
        }

        if ($key == 'object') {
            return $this->object;
        }

        $decorator = app()->make('Robbo\Presenter\Decorator');

        return $decorator->decorate(parent::__get($key));
    }
}
