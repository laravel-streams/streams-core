<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Filter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter
 */
class Filter implements FilterInterface
{

    /**
     * The filter slug.
     *
     * @var
     */
    protected $slug = null;

    /**
     * The filter prefix.
     *
     * @var null
     */
    protected $prefix = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The filter handler.
     *
     * @var null
     */
    protected $handler = null;

    /**
     * The filter placeholder.
     *
     * @var null
     */
    protected $placeholder = null;

    /**
     * Hook into the table query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function onTableQuerying(TableBuilder $builder, Builder $query)
    {
        $query = $query->where($this->getSlug(), 'LIKE', "%{$this->getValue()}%");
    }

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return array
     */
    public function getTableData()
    {
        $input = $this->getInput();

        return compact('input');
    }

    /**
     * Set the active flag.
     *
     * @param  $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Return the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the handler.
     *
     * @param  $handler
     * @return $this
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get the handler.
     *
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Set the placeholder.
     *
     * @param  $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder.
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the prefix.
     *
     * @param  $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the slug.
     *
     * @param  $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    protected function getName()
    {
        return $this->getPrefix() . $this->getSlug() . '_filter';
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    protected function getValue()
    {
        return app('request')->get($this->getName());
    }

    /**
     * Get the input.
     *
     * @return string
     */
    protected function getInput()
    {
        return null;
    }
}
