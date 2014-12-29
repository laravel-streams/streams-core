<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Contract;

/**
 * Interface ViewInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Contract
 */
interface ViewInterface
{

    /**
     * Get the view URL.
     *
     * @return string
     */
    public function getUrl();

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
     * Get the slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Set the view text.
     *
     * @param string $text
     * @return $this
     */
    public function setText($text);

    /**
     * Get the view text.
     *
     * @return string
     */
    public function getText();
}
