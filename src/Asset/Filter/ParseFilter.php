<?php namespace Anomaly\Streams\Platform\Asset\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

/**
 * Class ParseFilter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Asset\Filter
 */
class ParseFilter implements FilterInterface
{

    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset
     */
    public function filterLoad(AssetInterface $asset)
    {
        //
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $content = $asset->getContent();

        @app('files')->makeDirectory(storage_path('framework/views/asset'));
        app('files')->put(storage_path('framework/views/asset/' . (($filename = md5($content)) . '.twig')), $content);

        $content = view('base_path::storage/framework/views/asset/' . $filename)->render();

        $asset->setContent($content);
    }
}
