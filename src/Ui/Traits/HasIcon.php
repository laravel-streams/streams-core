<?php

namespace Anomaly\Streams\Platform\Ui\Traits;

use Anomaly\Streams\Platform\Ui\Icon\Icon;
use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;

/**
 * Trait HasIcon
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait HasIcon
{

    /**
     * The icon to display.
     *
     * @var string
     */
    protected $icon = null;

    /**
     * Get the icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the icon.
     *
     * @param array $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Return icon HTML.
     *
     * @param array $icon
     * @return null|string
     */
    public function icon()
    {
        if (!$this->icon) {
            return null;
        }

        return (new Icon())->setType(app(IconRegistry::class)->get($this->icon));
    }
}
