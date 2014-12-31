<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;

/**
 * Class Filter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class Filter implements FilterInterface, FilterHandlerInterface
{

    /**
     * The filter slug.
     *
     * @var string
     */
    protected $slug = 'default';

    /**
     * The filter prefix.
     *
     * @var null|string
     */
    protected $prefix = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The filter placeholder.
     *
     * @var null|string
     */
    protected $placeholder = null;

    /**
     * The TableQueryEvent handler.
     *
     * @var mixed
     */
    protected $tableQueryHandler;

    /**
     * Handle the TableQueryEvent.
     *
     * @param TableQueryEvent $event
     */
    public function onTableQuery(TableQueryEvent $event)
    {
        $handler = $this->getTableQueryHandler();

        if ($handler === null) {
            $this->handleTableQueryEvent($event);
        }

        if (is_string($handler) || $handler instanceof \Closure) {
            app()->call($handler, compact('event'));
        }
    }

    /**
     * Default handle for the TableQueryEvent.
     *
     * @param TableQueryEvent $event
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function handleTableQueryEvent(TableQueryEvent $event)
    {
        $query = $event->getQuery();

        $query = $query->where($this->getSlug(), 'LIKE', "%{$this->getValue()}%");

        return $query;
    }

    /**
     * Set the TableQueryEvent handler.
     *
     * @param $handler
     * @return $this
     */
    public function setTableQueryHandler($handler)
    {
        $this->tableQueryHandler = $handler;

        return $this;
    }

    /**
     * Get the TableQueryEvent handler.
     *
     * @return mixed
     */
    public function getTableQueryHandler()
    {
        return $this->tableQueryHandler;
    }

    /**
     * Get the filter input.
     *
     * @return null|string
     */
    public function getInput()
    {
        return null;
    }

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->getPrefix() . 'filter_' . $this->getSlug();
    }

    /**
     * Get the filter value.
     *
     * @return null|string
     */
    public function getValue()
    {
        return app('request')->get($this->getFieldName());
    }

    /**
     * Set the active flag.
     *
     * @param bool $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the filter placeholder.
     *
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the filter placeholder.
     *
     * @return null|string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set the filter prefix.
     *
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the filter prefix.
     *
     * @return null|string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the filter slug.
     *
     * @param $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the filter slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
