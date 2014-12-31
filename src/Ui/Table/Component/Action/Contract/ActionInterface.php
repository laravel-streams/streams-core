<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TablePostEvent;

/**
 * Interface ActionInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract
 */
interface ActionInterface extends ButtonInterface
{

    /**
     * Set the action handler.
     *
     * @param $handler
     * @return $this
     */
    public function setHandler($handler);

    /**
     * Get the action handler.
     *
     * @return mixed
     */
    public function getHandler();

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
