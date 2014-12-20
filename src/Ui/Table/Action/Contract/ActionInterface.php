<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Contract;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Interface ActionInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action\Contract
 */
interface ActionInterface
{

    /**
     * Hook into the table querying event.
     *
     * @param TableBuilder $builder
     */
    public function onTablePost(TableBuilder $builder);

    /**
     * Set the onTablePost handler.
     *
     * @param  $onTablePost
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
    public function getTableData();

    /**
     * Set the dropdown.
     *
     * @param array $dropdown
     * @return $this
     */
    public function setDropdown(array $dropdown);

    /**
     * Get the dropdown.
     *
     * @return array
     */
    public function getDropdown();

    /**
     * Set the attributes.
     *
     * @return array
     */
    public function setAttributes(array $attributes);

    /**
     * Get attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Set the class.
     *
     * @param  $class
     * @return mixed
     */
    public function setClass($class);

    /**
     * Get the class.
     *
     * @return mixed
     */
    public function getClass();

    /**
     * Set the icon.
     *
     * @param  $icon
     * @return mixed
     */
    public function setIcon($icon);

    /**
     * Get the icon.
     *
     * @return mixed
     */
    public function getIcon();

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
     * Set the type.
     *
     * @param  $type
     * @return mixed
     */
    public function setType($type);

    /**
     * Get the type.
     *
     * @return mixed
     */
    public function getType();
}
