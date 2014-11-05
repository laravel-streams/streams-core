<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

/**
 * Class Theme
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class Theme extends Addon implements PresentableInterface
{

    /**
     * Determines whether this is
     * an admin theme or not.
     *
     * @var bool
     */
    protected $admin = false;

    /**
     * Determines whether this is
     * the active theme or not.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Get the admin flag.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the active flag.
     *
     * @param $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Return the theme's tag counterpart.
     *
     * @return mixed
     */
    public function toTag()
    {
        if (!$tag = $this->transform(__FUNCTION__)) {

            $tag = 'Anomaly\Streams\Platform\Addon\Theme\ThemeTag';
        }

        return app()->make($tag, ['module' => $this]);
    }

    /**
     * Return the theme's presenter counterpart.
     *
     * @return mixed
     */
    public function toPresenter()
    {
        if (!$presenter = $this->transform(__FUNCTION__)) {

            $presenter = 'Anomaly\Streams\Platform\Addon\Theme\ThemePresenter';
        }

        return app()->make($presenter, [$this]);
    }

    /**
     * @return ThemePresenter
     */
    public function decorate()
    {
        return $this->toPresenter();
    }
}
