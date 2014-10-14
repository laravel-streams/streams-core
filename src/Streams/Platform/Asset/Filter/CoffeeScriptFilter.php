<?php namespace Streams\Platform\Asset\Filter;

use Assetic\Asset\AssetInterface;

class CoffeeScriptFilter extends \Assetic\Filter\CoffeeScriptFilter
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
 