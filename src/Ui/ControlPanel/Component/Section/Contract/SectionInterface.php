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
     * Get the slug.
     *
     * @return null|string
     */
    public function getSlug();

    /**
     * Set the slug.
     *
     * @param $slug
     * @return $this
     */
    public function setSlug($slug);

    /**
     * Get the icon.
     *
     * @return null|string
     */
    public function getIcon();

    /**
     * Set the icon.
     *
     * @param $icon
     * @return $this
     */
    public function setIcon($icon);

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
     * Get the highlighted flag.
     *
     * @return boolean
     */
    public function isHighlighted();

    /**
     * Set the highlighted flag.
     *
     * @param boolean $active
     * @return $this
     */
    public function setHighlighted($highlighted);

    /**
     * Get the parent.
     *
     * @return null|string
     */
    public function getParent();

    /**
     * Set the parent.
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent);

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
     * Get the permission.
     *
     * @return null|string
     */
    public function getPermission();

    /**
     * Set the permission.
     *
     * @param $permission
     * @return $this
     */
    public function setPermission($permission);

    /**
     * Get the breadcrumb.
     *
     * @return null|string
     */
    public function getBreadcrumb();

    /**
     * Set the breadcrumb.
     *
     * @param $breadcrumb
     * @return $this
     */
    public function setBreadcrumb($breadcrumb);

    /**
     * Get the HREF attribute.
     *
     * @return string
     */
    public function getHref();
}
