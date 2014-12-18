<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface FilterInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter\Contract
 */
interface FilterInterface
{

    /**
     * Hook into the table query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     * @return Builder
     */
    public function onTableQuerying(TableBuilder $builder, Builder $query);

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return mixed
     */
    public function getTableData();

    /**
     * Set the placeholder.
     *
     * @param  $placeholder
     * @return mixed
     */
    public function setPlaceholder($placeholder);

    /**
     * Get the placeholder.
     *
     * @return mixed
     */
    public function getPlaceholder();

    /**
     * Set the handler.
     *
     * @param  $handler
     * @return mixed
     */
    public function setHandler($handler);

    /**
     * Get the handler.
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
     * Return the active flag.
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
}
