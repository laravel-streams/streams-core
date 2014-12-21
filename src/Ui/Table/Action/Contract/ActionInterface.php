<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Interface ActionInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action\Contract
 */
interface ActionInterface extends ButtonInterface
{

    /**
     * Hook into the table querying event.
     *
     * @param TableBuilder $builder
     */
    public function onTablePost(TableBuilder $builder);

    /**
     * Set the tablePostHandler handler.
     *
     * @param  $tablePostHandler
     * @return $this
     */
    public function setTablePostHandler($tablePostHandler);

    /**
     * Get the tablePostHandler handler.
     *
     * @return mixed
     */
    public function getTablePostHandler();

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
     * Set the prefix.
     *
     * @param  $prefix
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
     * @param  $slug
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
     * Get table data.
     *
     * @return array
     */
    public function toArray();
}
