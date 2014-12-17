<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TablePostEvent;
use Illuminate\Support\Collection;

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
     * The onTablePost handler.
     *
     * @var null
     */
    protected $onTablePost = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The action's prefix.
     *
     * @var string|null
     */
    protected $prefix = null;

    /**
     * The action slug.
     *
     * @var string|null
     */
    protected $slug = null;

    /**
     * Create a new Action instance.
     *
     * @param Collection $attributes
     */
    public function __construct(Collection $attributes)
    {
        $attributes->put('type', 'submit');
        $attributes->put('name', 'action');

        parent::__construct($attributes);
    }

    /**
     * Hook into the table querying event.
     *
     * @param TablePostEvent $event
     */
    public function onTablePost(TablePostEvent $event)
    {
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
     * Set the onTablePost handler.
     *
     * @param $onTablePost
     * @return $this
     */
    public function setOnTablePost($onTablePost)
    {
        $this->onTablePost = $onTablePost;

        return $this;
    }

    /**
     * Get the onTablePost handler.
     *
     * @return mixed
     */
    public function getOnTablePost()
    {
        return $this->onTablePost;
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
     * @return string
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
}
