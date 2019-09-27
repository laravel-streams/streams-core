<?php namespace Anomaly\Streams\Platform\Asset;

/**
 * Class AssetParser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssetParser
{

    /**
     * Parse some content.
     *
     * @param $content
     * @return string
     */
    public function parse($content)
    {
        if (!is_dir($path = storage_path('framework/views/asset'))) {
            mkdir($path);
        }

        file_put_contents(storage_path('framework/views/asset/' . (($filename = md5($content)) . '.twig')), $content);

        return view('root::storage/framework/views/asset/' . $filename)->render();
    }
}
