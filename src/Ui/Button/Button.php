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
     * The button text.
     *
     * @var null
     */
    protected $text;

    /**
     * The button icon.
     *
     * @var null
     */
    protected $icon;

    /**
     * The button type.
     *
     * @var string
     */
    protected $type;

    /**
     * The button class.
     *
     * @var null
     */
    protected $class;

    /**
     * The button's attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * The button's dropdown.
     *
     * @var array
     */
    protected $dropdown;

    /**
     * Create a new Button instance.
     *
     * @param null   $text
     * @param null   $icon
     * @param null   $class
     * @param string $type
     * @param array  $dropdown
     * @param array  $attributes
     */
    function __construct(
        $text = null,
        $icon = null,
        $class = null,
        $type = 'default',
        array $dropdown = [],
        array $attributes = []
    ) {
        $this->icon       = $icon;
        $this->text       = $text;
        $this->type       = $type;
        $this->class      = $class;
        $this->dropdown   = $dropdown;
        $this->attributes = $attributes;
    }

    /**
     * Get the table data.
     *
     * @return array
     */
    public function toArray()
    {
        $type       = $this->getType();
        $icon       = $this->getIcon();
        $text       = $this->getText();
        $class      = $this->getClass();
        $dropdown   = $this->getDropdown();
        $attributes = $this->getAttributes();

        if (is_string($text)) {
            $text = trans($text);
        }

        $data = compact('text', 'type', 'class', 'icon', 'attributes', 'dropdown');

        $data['attributes'] = app('html')->attributes($data['attributes']);

        return $data;
    }

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
     * @param  $class
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
     * @param  $icon
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
     * @param  $text
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
     * @param  $type
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
}
