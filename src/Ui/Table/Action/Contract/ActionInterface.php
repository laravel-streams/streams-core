<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TablePostEvent;

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
     * Hook into the table querying event.
     *
     * @param TablePostEvent $event
     */
    public function onTablePost(TablePostEvent $event);

    /**
     * Set the onTablePost handler.
     *
     * @param $onTablePost
     * @return $this
     */
    public function setOnTablePost($onTablePost);

    /**
     * Get the onTablePost handler.
     *
     * @return mixed
     */
    public function getOnTablePost();

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
}
