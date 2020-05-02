<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Ui\Traits\HasIcon;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;

/**
 * Class Section
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Section implements SectionInterface, Arrayable, Jsonable
{
    use HasIcon;
    use HasAttributes;

    /**
     * The link attributes.
     *
     * @var array
     */
    protected $attributes = [
        'slug' => null,
        'title' => null,
        'label' => null,
        'active' => false,
        'matcher' => null,
        'permalink' => null,
        'description' => null,
        'highlighted' => false,
        'context' => 'danger',
        'parent' => null,
        'policy' => null,
        'buttons' => [],
        'breadcrumb' => null,
        'hidden' => false,
    ];

    /**
     * Return if the section is
     * a sub-section or not.
     *
     * @return bool
     */
    public function isSubSection()
    {
        return (bool) $this->getParent();
    }

    /**
     * Get the HREF attribute.
     *
     * @param  null $path
     * @return string
     */
    public function href($path = null)
    {
        return ($this->permalink ?: $this->attr('attibutes.href')) . ($path ? '/' . $path : $path);
    }

    /**
     * Return the child sections.
     *
     * @return SectionCollection
     */
    public function children()
    {
        return app(SectionCollection::class)->children($this->slug);
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge($this->attr('attributes'), [
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
            $this->class,
            $this->active ? 'active' : null,
            $this->highlighted ? 'highlighted' : null,
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
