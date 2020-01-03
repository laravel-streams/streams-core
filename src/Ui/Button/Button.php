<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Traits\HasIcon;
use Anomaly\Streams\Platform\Ui\Traits\HasHtmlAttributes;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;

/**
 * Class Button
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Button implements ButtonInterface
{

    use HasIcon;
    use HasClassAttribute;
    use HasHtmlAttributes;

    /**
     * The action tag.
     *
     * @var string
     */
    protected $tag = 'a';

    /**
     * The button URL.
     *
     * @var null|string
     */
    protected $url = null;

    /**
     * The button text.
     *
     * @var null|string
     */
    protected $text = null;

    /**
     * The button type.
     *
     * @var null|string
     */
    protected $type = 'default';

    /**
     * The required permission.
     *
     * @var null|string
     */
    protected $permission = null;

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
        return '<' . $this->getTag() . ' ' . html_attributes(array_merge($this->attributes(), $attributes)) . '>';
    }

    /**
     * Return the open tag.
     *
     * @return string
     */
    public function close()
    {
        return '</' . $this->getTag() . '>';
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
     * Get the permission.
     *
     * @return null|string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the permission.
     *
     * @param $permission
     * @return $this
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get the button type.
     *
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the button type.
     *
     * @param  string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * Set the button text.
     *
     * @param  string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the button URL.
     *
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the URL.
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the button tag.
     *
     * @return null|string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set the tag.
     *
     * @param $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

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
}
