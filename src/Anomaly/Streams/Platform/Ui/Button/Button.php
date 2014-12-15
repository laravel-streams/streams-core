<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

/**
 * Class Button
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
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
     * Create a new Button instance.
     *
     * @param string $type
     * @param null   $text
     * @param null   $class
     * @param null   $icon
     * @param array  $attributes
     */
    public function __construct($type = 'default', $text = null, $class = null, $icon = null, array $attributes = [])
    {
        $this->icon       = $icon;
        $this->class      = $class;
        $this->text       = $text;
        $this->type       = $type;
        $this->attributes = $attributes;
    }

    /**
     * Get the view data.
     *
     * @param array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $type       = $this->getType();
        $icon       = $this->getIcon();
        $text       = $this->getText();
        $class      = $this->getClass();
        $attributes = $this->getAttributes();

        if (is_string($text)) {
            $text = trans($text);
        }

        $data = compact('text', 'type', 'class', 'icon', 'attributes');

        $data['attributes'] = app('html')->attributes($data['attributes']);

        return $data;
    }

    /**
     * Pull an attribute.
     *
     * @param      $attribute
     * @param null $default
     * @return mixed
     */
    public function pullAttribute($attribute, $default = null)
    {
        return array_get($this->attributes, $attribute, $default);
    }

    /**
     * Put an attribute.
     *
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function putAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Set the attributes.
     *
     * @param $attributes
     * @return $this
     */
    public function setAttributes($attributes)
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
     * @param $class
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
     * @param $icon
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
     * @param $text
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
     * @param $type
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
