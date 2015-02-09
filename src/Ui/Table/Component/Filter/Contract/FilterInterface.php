<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

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
     * Set the filter handler.
     *
     * @param $handler
     * @return $this
     */
    public function setHandler($handler);

    /**
     * Get the filter handler.
     *
     * @return mixed
     */
    public function getHandler();

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
    public function getInputName();

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
