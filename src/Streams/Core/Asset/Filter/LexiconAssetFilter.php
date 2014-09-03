<?php namespace Streams\Core\Asset\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

class LexiconAssetFilter implements FilterInterface
{
    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset
     */
    public function filterLoad(AssetInterface $asset)
    {
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $content = $asset->getContent();

        $content = \View::parse($content);

        $asset->setContent($content);
    }
}
