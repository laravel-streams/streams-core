<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Form\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class Action
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Action
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
     * The action prefix.
     *
     * @var null
     */
    protected $prefix;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active;

    /**
     * The action handler.
     *
     * @var null
     */
    protected $handler;

    /**
     * Create a new Action instance.
     *
     * @param string $slug
     * @param null   $text
     * @param null   $icon
     * @param null   $class
     * @param null   $prefix
     * @param bool   $active
     * @param null   $handler
     * @param string $type
     * @param array  $attributes
     */
    public function __construct(
        $slug,
        $text = null,
        $icon = null,
        $class = null,
        $prefix = null,
        $active = false,
        $handler = null,
        $type = 'default',
        array $attributes = []
    ) {
        $this->slug    = $slug;
        $this->prefix  = $prefix;
        $this->active  = $active;
        $this->handler = $handler;

        parent::__construct($type, $text, $class, $icon, $attributes);
    }

    /**
     * Handle the action.
     *
     * @param Form $form
     */
    public function handle(Form $form)
    {
        //
    }

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return array
     */
    public function viewData(array $arguments = [])
    {
        $data = parent::viewData();

        $value = $this->getSlug();

        return $data + compact('value');
    }

    /**
     * Set the action handler.
     *
     * @param $handler
     * @return $this
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get the action handler.
     *
     * @return null
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Set the active flag.
     *
     * @param $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = ($active);

        return $this;
    }

    /**
     * Return the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return ($this->active);
    }

    /**
     * Set the action prefix.
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
     * Ge the action prefix.
     *
     * @return null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the action slug.
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
     * Get the action slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
