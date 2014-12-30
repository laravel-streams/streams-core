<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\FormPostEvent;

/**
 * Class Action
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
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
     * The FormPostEvent handler.
     *
     * @var mixed
     */
    protected $formPostHandler;

    /**
     * Handle the FormPostEvent.
     *
     * @param FormPostEvent $event
     */
    public function onFormPost(FormPostEvent $event)
    {
        $handler = $this->getFormPostHandler();

        if ($handler === null) {
            $this->handleFormPostEvent($event);
        }

        if (is_string($handler) || $handler instanceof \Closure) {
            app()->call($handler, compact('event'));
        }
    }

    /**
     * Default handle for the FormPostEvent.
     *
     * @param FormPostEvent $event
     */
    protected function handleFormPostEvent(FormPostEvent $event)
    {
    }

    /**
     * Set the FormPostEvent handler.
     *
     * @param $handler
     * @return $this
     */
    public function setFormPostHandler($handler)
    {
        $this->formPostHandler = $handler;

        return $this;
    }

    /**
     * Get the FormPostEvent handler.
     *
     * @return mixed
     */
    public function getFormPostHandler()
    {
        return $this->formPostHandler;
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
