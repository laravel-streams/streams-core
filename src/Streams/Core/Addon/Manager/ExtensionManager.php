<?php namespace Streams\Core\Addon\Manager;

use Streams\Core\Addon\Model\ExtensionModel;
use Streams\Core\Addon\Collection\ExtensionCollection;

class ExtensionManager extends AddonManager
{
    /**
     * The folder within addons locations to load extensions from.
     *
     * @var string
     */
    protected $folder = 'extensions';

    /**
     * Get a single extension.
     *
     * @param string $slug
     * @param array  $parameters
     * @return AddonAbstract
     */
    public function find($slug, $parameters = [])
    {
        if (strpos($slug, '::') !== false) {
            list($addon, $extension) = explode('::', $slug);

            list($addonType, $addonSlug) = explode('.', $addon);

            list($extensionSlug, $extensionType) = explode('.', $extension);

            $slug = "{$addonSlug}_{$addonType}_{$extensionSlug}_{$extensionType}";
        }

        return parent::find($slug, $parameters);
    }

    /**
     * Get all instantiated extensions matching a pattern.
     *
     * @return array
     */
    public function get($namespace, $type)
    {
        list($addonType, $addonSlug) = explode('.', $namespace);

        $addons = [];

        foreach ($this->registeredAddons as $info) {
            $parts = explode('_', $info['slug']);

            if ($addonType == $parts[1] and $addonSlug == $parts[0] and $type == $parts[3]) {
                $addons[$info['slug']] = $this->find($info['slug']);
            }
        }

        return $this->newCollection($addons);
    }

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return new ExtensionModel();
    }

    /**
     * Return a new collection instance.
     *
     * @param array $extensions
     * @return null|ExtensionCollection
     */
    protected function newCollection(array $extensions = [])
    {
        return new ExtensionCollection($extensions);
    }
}
