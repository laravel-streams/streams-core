<?php namespace Anomaly\Streams\Platform\Ui\Button\Contract;

/**
 * Interface ButtonInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button\Contract
 */
interface ButtonInterface
{
    /**
     * Get the view data.
     *
     * @param array $arguments
     * @return mixed
     */
    public function viewData(array $arguments = []);

    /**
     * Pull an attribute.
     *
     * @param      $attribute
     * @param null $default
     * @return mixed
     */
    public function pullAttribute($attribute, $default = null);

    /**
     * Put an attribute.
     *
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function putAttribute($attribute, $value);

    /**
     * Set attributes.
     *
     * @param $attributes
     * @return mixed
     */
    public function setAttributes($attributes);

    /**
     * Get attributes.
     *
     * @return mixed
     */
    public function getAttributes();

    /**
     * Set the class.
     *
     * @param $class
     * @return mixed
     */
    public function setClass($class);

    /**
     * Get the class.
     *
     * @return mixed
     */
    public function getClass();

    /**
     * Set the icon.
     *
     * @param $icon
     * @return mixed
     */
    public function setIcon($icon);

    /**
     * Get the icon.
     *
     * @return mixed
     */
    public function getIcon();

    /**
     * Set the text.
     *
     * @param $text
     * @return mixed
     */
    public function setText($text);

    /**
     * Get the text.
     *
     * @return mixed
     */
    public function getText();

    /**
     * Set the type.
     *
     * @param $type
     * @return mixed
     */
    public function setType($type);

    /**
     * Get the type.
     *
     * @return mixed
     */
    public function getType();
}
