<?php namespace Anomaly\Streams\Platform\Ui\Table\Button\Contract;

/**
 * Interface ButtonInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Button\Contract
 */
interface ButtonInterface
{

    /**
     * Get table data.
     *
     * @return array
     */
    public function toArray();

    /**
     * Set the dropdown.
     *
     * @param array $dropdown
     * @return $this
     */
    public function setDropdown(array $dropdown);

    /**
     * Get the dropdown.
     *
     * @return array
     */
    public function getDropdown();

    /**
     * Set the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes);

    /**
     * Get attributes.
     *
     * @return mixed
     */
    public function getAttributes();

    /**
     * Set the class.
     *
     * @param  $class
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
     * @param  $icon
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
     * @param  $text
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
     * @param  $type
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
