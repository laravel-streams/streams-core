<?php namespace Streams\Core\Asset\Filter;

use Assetic\Asset\AssetInterface;

class PhpCssEmbedFilter extends \Assetic\Filter\PhpCssEmbedFilter
{
    /**
     * Override the filter dump method.
     *
     * @param AssetInterface $asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $asset->setContent(\View::parse($asset->getContent()));

        return parent::filterDump($asset);
    }
}