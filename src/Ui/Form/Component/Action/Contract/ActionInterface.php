<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\FormPostEvent;

/**
 * Interface ActionInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract
 */
interface ActionInterface extends ButtonInterface
{

    /**
     * Handle the FormPostEvent.
     *
     * @param FormPostEvent $event
     */
    public function onFormPost(FormPostEvent $event);

    /**
     * Set the FormPostEvent handler.
     *
     * @param $handler
     * @return $this
     */
    public function setFormPostHandler($handler);

    /**
     * Get the FormPostEvent handler.
     *
     * @return mixed
     */
    public function getFormPostHandler();

    /**
     * Set the active flag.
     *
     * @param  $active
     * @return mixed
     */
    public function setActive($active);

    /**
     * Get the active flag.
     *
     * @return mixed
     */
    public function isActive();

    /**
     * Set the action prefix.
     *
     * @param  $prefix
     * @return mixed
     */
    public function setPrefix($prefix);

    /**
     * Get the action prefix.
     *
     * @return mixed
     */
    public function getPrefix();

    /**
     * Set the action slug.
     *
     * @param  $slug
     * @return mixed
     */
    public function setSlug($slug);

    /**
     * Get the action slug.
     *
     * @return mixed
     */
    public function getSlug();
}
