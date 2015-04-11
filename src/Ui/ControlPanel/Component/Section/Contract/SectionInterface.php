<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract;

/**
 * Interface SectionInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract
 */
interface SectionInterface
{

    /**
     * Get the text.
     *
     * @return string
     */
    public function getText();

    /**
     * Set the text.
     *
     * @param string $text
     */
    public function setText($text);

    /**
     * Get the active flag.
     *
     * @return boolean
     */
    public function isActive();

    /**
     * Set the active flag.
     *
     * @param boolean $active
     */
    public function setActive($active);

    /**
     * Get the buttons.
     *
     * @return array|string
     */
    public function getButtons();

    /**
     * Set the buttons.
     *
     * @param array|string $buttons
     */
    public function setButtons($buttons);

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Set the attributes.
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * Get the HREF attribute.
     *
     * @return string
     */
    public function getHref();
}
