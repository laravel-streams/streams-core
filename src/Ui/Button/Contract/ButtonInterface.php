<?php namespace Anomaly\Streams\Platform\Ui\Button\Contract;

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
     * Set the parent.
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent);

    /**
     * Get the parent.
     *
     * @return string|null
     */
    public function getParent();

    /**
     * Return whether the button is a dropdown or not.
     *
     * @return bool
     */
    public function isDropdown();

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
     * Set the enabled flag.
     *
     * @param $enabled
     * @return mixed
     */
    public function setEnabled($enabled);

    /**
     * Get the enabled flag.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Get the entry.
     *
     * @return mixed|null
     */
    public function getEntry();

    /**
     * Set the table.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry);

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
     * Set the button type.
     *
     * @param string $type
     * @return $this
     */
    public function setType($type);

    /**
     * Get the button type.
     *
     * @return string
     */
    public function getType();

    /**
     * Set the button size.
     *
     * @param $size
     * @return $this
     */
    public function setSize($size);

    /**
     * Get the button size.
     *
     * @return string
     */
    public function getSize();

    /**
     * Set the URL.
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * Get the URL.
     *
     * @return null|string
     */
    public function getUrl();
}
