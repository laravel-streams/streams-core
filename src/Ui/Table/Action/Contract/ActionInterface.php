<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryingEvent;

/**
 * Interface ActionInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Contract
 */
interface ActionInterface extends ButtonInterface
{

    /**
     * Set the active flag.
     *
     * @param $active
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
     * Set the prefix.
     *
     * @param $prefix
     * @return mixed
     */
    public function setPrefix($prefix);

    /**
     * Get the prefix.
     *
     * @return mixed
     */
    public function getPrefix();

    /**
     * Set the slug.
     *
     * @param $slug
     * @return mixed
     */
    public function setSlug($slug);

    /**
     * Get the slug.
     *
     * @return mixed
     */
    public function getSlug();

    /**
     * Hook into the table querying event.
     *
     * @param TableQueryingEvent $event
     */
    public function onTableQuerying(TableQueryingEvent $event);
}
