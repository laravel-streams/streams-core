<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

/**
 * Class Button
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Button
 */
class Button implements ButtonInterface
{

    /**
     * The button tag.
     *
     * @var string
     */
    protected $tag = 'anchor';

    /**
     * The button text.
     *
     * @var null|string
     */
    protected $text = null;

    /**
     * The button icon.
     *
     * @var null|string
     */
    protected $icon = null;

    /**
     * The button type.
     *
     * @var null|string
     */
    protected $type = 'default';

    /**
     * The button class.
     *
     * @var null|string
     */
    protected $class = null;

    /**
     * The button's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The button's dropdown.
     *
     * @var array
     */
    protected $dropdown = [];

    /**
     * Set the dropdown.
     *
     * @param array $dropdown
     * @return $this
     */
    public function setDropdown(array $dropdown)
    {
        $this->dropdown = $dropdown;

        return $this;
    }

    /**
     * Get the dropdown.
     *
     * @return array
     */
    public function getDropdown()
    {
        return $this->dropdown;
    }

    /**
     * Set the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the class.
     *
     * @param string $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get the class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the icon.
     *
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the button text.
     *
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the button text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the button type.
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the button type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the button tag.
     *
     * @param string $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get the button tag.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }
}
