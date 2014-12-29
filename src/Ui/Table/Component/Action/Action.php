<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TablePostEvent;

/**
 * Class Action
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class Action extends Button implements ActionInterface, ActionHandlerInterface
{

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The action prefix.
     *
     * @var string|null
     */
    protected $prefix = null;

    /**
     * The action slug.
     *
     * @var string
     */
    protected $slug = 'default';

    /**
     * The TablePostEvent handler.
     *
     * @var mixed
     */
    protected $tablePostHandler;

    /**
     * Handle the TablePostEvent.
     *
     * @param TablePostEvent $event
     */
    public function onTablePost(TablePostEvent $event)
    {
        $handler = $this->getTablePostHandler();

        if ($handler === null) {
            $this->handleTablePostEvent($event);
        }

        if (is_string($handler) or $handler instanceof \Closure) {
            app()->call($handler, compact('event'));
        }
    }

    /**
     * Default handle for the TablePostEvent.
     *
     * @param TablePostEvent $event
     */
    protected function handleTablePostEvent(TablePostEvent $event)
    {
    }

    /**
     * Set the TablePostEvent handler.
     *
     * @param $handler
     * @return $this
     */
    public function setTablePostHandler($handler)
    {
        $this->tablePostHandler = $handler;

        return $this;
    }

    /**
     * Get the TablePostEvent handler.
     *
     * @return mixed
     */
    public function getTablePostHandler()
    {
        return $this->tablePostHandler;
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
     * Set the action prefix.
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
     * Get the action prefix.
     *
     * @return null|string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the action slug.
     *
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the action slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
