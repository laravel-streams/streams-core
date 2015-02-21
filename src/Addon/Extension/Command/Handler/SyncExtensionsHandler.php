<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class SyncExtensionsHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class SyncExtensionsHandler
{

    /**
     * The extension repository.
     *
     * @var ExtensionRepositoryInterface
     */
    protected $extensions;

    /**
     * The loaded extensions.
     *
     * @var ExtensionCollection
     */
    protected $collection;

    /**
     * Create a new SyncExtensionsHandler instance.
     *
     * @param ExtensionRepositoryInterface $extensions
     */
    public function __construct(ExtensionCollection $collection, ExtensionRepositoryInterface $extensions)
    {
        $this->extensions = $extensions;
        $this->collection = $collection;
    }

    /**
     * Sync database extensions with physical ones.
     */
    public function handle()
    {
        $extensions = $this->extensions->all();

        foreach ($this->collection->all() as $extension) {
            $this->sync($extensions, $extension);
        }
    }

    /**
     * Sync a extension.
     *
     * @param \Anomaly\Streams\Platform\Model\EloquentCollection $extensions
     * @param Extension                                          $extension
     */
    protected function sync(EloquentCollection $extensions, Extension $extension)
    {
        if (!$extensions->findBySlug($extension->getSlug())) {
            $this->extensions->create($extension->getSlug());
        }
    }
}
