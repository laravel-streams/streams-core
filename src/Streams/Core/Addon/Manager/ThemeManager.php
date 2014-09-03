<?php namespace Streams\Core\Addon\Manager;

use Streams\Core\Addon\Model\ThemeModel;
use Streams\Core\Addon\Collection\ThemeCollection;

class ThemeManager extends AddonManager
{
    /**
     * The folder within addons locations to load themes from.
     *
     * @var string
     */
    protected $folder = 'themes';

    /**
     * Get the active admin theme.
     *
     * @return null
     */
    public function getAdminTheme()
    {
        /**
         * @todo - Eventually, this will be a setting that
         * returns the active admin theme slug
         **/

        $slug = 'streams';

        return $this->get($slug);
    }

    /**
     * Get the active public theme.
     *
     * @return null
     */
    public function getPublicTheme()
    {
        /**
         * @todo - Eventually, this will be a setting that
         * returns the active public theme slug
         **/

        $slug = 'aiws';

        return $this->get($slug);
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
