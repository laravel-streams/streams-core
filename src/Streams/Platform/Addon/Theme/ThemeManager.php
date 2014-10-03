<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\AddonManager;

class ThemeManager extends AddonManager
{
    /**
     * The folder within addons locations to load themes from.
     *
     * @var string
     */
    protected $folder = 'themes';

    /**
     * The active theme slug.
     *
     * @var null
     */
    protected $active = null;

    /**
     * Return the active module.
     *
     * @return null|\Streams\Platform\Addon\AddonAbstract
     */
    public function active()
    {
        if ($this->exists($this->active)) {
            return $this->make($this->active);
        }

        return null;
    }

    /**
     * Get the active module slug.
     *
     * @return null
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the active module slug.
     *
     * @param $slug
     * @return $this
     */
    public function setActive($slug)
    {
        $this->active = $slug;

        return $this;
    }

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return new ThemeModel();
    }

    /**
     * Return a new collection instance.
     *
     * @param array $themes
     * @return null|ThemeCollection
     */
    protected function newCollection(array $themes = [])
    {
        return new ThemeCollection($themes);
    }
}
