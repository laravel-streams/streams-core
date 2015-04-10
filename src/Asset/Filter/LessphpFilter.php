<?php namespace Anomaly\Streams\Platform\Asset\Filter;

use Assetic\Asset\AssetInterface;

/**
 * Class LessphpFilter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Asset\Filter
 */
class LessphpFilter extends \Assetic\Filter\LessphpFilter
{

    /**
     * Override the filter dump method.
     *
     * @param AssetInterface $asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $content = $asset->getContent();

        @app('files')->makeDirectory(storage_path('framework/views/asset'));
        app('files')->put(storage_path('framework/views/asset/' . (($filename = md5($content)) . '.twig')), $content);

        $content = view('storage::framework/views/asset/' . $filename)->render();

        $asset->setContent($content);
    }
}
