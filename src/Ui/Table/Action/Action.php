<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryingEvent;

/**
 * Class Action
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
 */
class Action extends Button implements ActionInterface
{

    /**
     * The action slug.
     *
     * @var string
     */
    protected $slug;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active;

    /**
     * The action's prefix.
     *
     * @var null
     */
    protected $prefix;

    /**
     * Create a new Action instance.
     *
     * @param string $slug
     * @param null   $icon
     * @param null   $text
     * @param null   $class
     * @param null   $prefix
     * @param bool   $active
     * @param string $type
     * @param array  $attributes
     */
    public function __construct(
        $slug,
        $icon = null,
        $text = null,
        $class = null,
        $prefix = null,
        $active = false,
        $type = 'default',
        array $attributes = []
    ) {
        parent::__construct($type, $text, $class, $icon, $attributes);

        $this->slug   = $slug;
        $this->active = $active;
        $this->prefix = $prefix;

        $this->putAttribute('type', 'submit');
        $this->putAttribute('name', 'action');
    }

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $data = parent::viewData($arguments);

        $data['slug'] = $this->getSlug();

        return $data;
    }

    /**
     * Set the active flag.
     *
     * @param $active
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
     * Set the prefix.
     *
     * @param $prefix
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
     * @return null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the slug.
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
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Hook into the table querying event.
     *
     * @param TableQueryingEvent $event
     */
    public function onTableQuerying(TableQueryingEvent $event)
    {
    }
}
