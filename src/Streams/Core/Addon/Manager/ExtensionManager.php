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
