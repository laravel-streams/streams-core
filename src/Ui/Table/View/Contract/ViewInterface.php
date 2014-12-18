<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface ViewInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View\Contract
 */
interface ViewInterface
{

    /**
     * Hook into the table query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     * * @return Builder
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
     * Set the attributes.
     *
     * @param  array $attributes
     * @return mixed
     */
    public function setAttributes(array $attributes);

    /**
     * Get the attributes.
     *
     * @return mixed
     */
    public function getAttributes();

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
     * Set the text.
     *
     * @param  $text
     * @return mixed
     */
    public function setText($text);

    /**
     * Get the text.
     *
     * @return mixed
     */
    public function getText();

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
