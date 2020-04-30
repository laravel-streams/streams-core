<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Ui\Traits\HasIcon;
use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;
use Anomaly\Streams\Platform\Ui\Traits\HasHtmlAttributes;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

/**
 * Class Button
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Button implements ButtonInterface, Arrayable, Jsonable
{

    use HasIcon;
    use HasAttributes;
    use HasClassAttribute;
    use HasHtmlAttributes;

    /**
     * The button attributes.
     *
     * @var array
     */
    protected $attributes = [
        'tag' => 'a',
        'url' => null,
        'text' => null,
        'policy' => null,
        'type' => 'default',
    ];

    /**
     * The disabled flag.
     *
     * @var bool
     */
    protected $disabled = false;

    /**
     * The enabled flag.
     *
     * @var bool
     */
    protected $enabled = true;

    /**
     * The primary flag.
     *
     * @var string
     */
    protected $primary = false;

    /**
     * The entry object.
     *
     * @var null|mixed
     */
    protected $entry = null;

    /**
     * Return the open tag.
     *
     * @param array $attributes
     * @return string
     */
    public function open(array $attributes = [])
    {
        return '<' . $this->tag . ' ' . html_attributes(array_merge($this->attributes(), $attributes)) . '>';
    }

    /**
     * Return the open tag.
     *
     * @return string
     */
    public function close()
    {
        return '</' . $this->tag . '>';
    }

    /**
     * Get the disabled flag.
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set the disabled flag.
     *
     * @param $disabled
     * @return $this
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Set the enabled flag.
     *
     * @param $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get the enabled flag.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set the primary flag.
     *
     * @param bool $primary
     * @return $this;
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * Return the primary flag.
     *
     * @return bool
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * Get the entry.
     *
     * @return mixed|null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the table.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge($this->attributes, [
            'class' => $this->class(),
        ], $attributes);
    }

    /**
     * Return class HTML.
     *
     * @param string $class
     * @return null|string
     */
    public function class($class = null)
    {
        return trim(implode(' ', [
            $class,
            $this->getClass()
        ]));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param  string  $key
     * @param  mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
