<?php namespace Streams\Platform\Asset\Filter;

use Assetic\Asset\AssetInterface;

class ScssphpFilter extends \Assetic\Filter\ScssphpFilter
{
    /**
     * Override the filter dump method.
     *
     * @param AssetInterface $asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $asset->setContent(app('view')->parse($asset->getContent()));

        return parent::filterDump($asset);
    }
}