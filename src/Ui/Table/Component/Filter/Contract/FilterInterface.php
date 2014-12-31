<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

use Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent;

/**
 * Interface FilterInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract
 */
interface FilterInterface
{

    /**
     * Handle the TableQueryEvent.
     *
     * @param TableQueryEvent $event
     */
    public function onTableQuery(TableQueryEvent $event);

    /**
     * Set the TableQueryEvent handler.
     *
     * @param $tableQueryHandler
     * @return $this
     */
    public function setTableQueryHandler($tableQueryHandler);

    /**
     * Get the TableQueryEvent handler.
     *
     * @return mixed
     */
    public function getTableQueryHandler();

    /**
     * Get the filter input.
     *
     * @return null|string
     */
    public function getInput();

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function getFieldName();

    /**
     * Get the filter value.
     *
     * @return null|string
     */
    public function getValue();

    /**
     * Set the active flag.
     *
     * @param bool $active
     * @return $this
     */
    public function setActive($active);

    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive();

    /**
     * Set the filter placeholder.
     *
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder);

    /**
     * Get the filter placeholder.
     *
     * @return null|string
     */
    public function getPlaceholder();

    /**
     * Set the filter prefix.
     *
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix);

    /**
     * Get the filter prefix.
     *
     * @return null|string
     */
    public function getPrefix();

    /**
     * Set the filter slug.
     *
     * @param $slug
     * @return $this
     */
    public function setSlug($slug);

    /**
     * Get the filter slug.
     *
     * @return string
     */
    public function getSlug();
}
