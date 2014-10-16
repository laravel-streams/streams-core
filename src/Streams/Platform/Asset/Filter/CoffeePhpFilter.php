<?php namespace Streams\Platform\Asset\Filter;

use CoffeeScript\Compiler;
use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

class CoffeePhpFilter implements FilterInterface
{

    public function filterLoad(AssetInterface $asset)
    {
        //
    }

    public function filterDump(AssetInterface $asset)
    {

        $content = $asset->getContent(app('view')->parse($asset->getContent()));

        try {
            if (trim($content)) {
                $content = Compiler::compile($content, array('filename' => $asset->getSourcePath()));
            }
        } catch (\Exception $e) {
            $content = $e->getMessage();
        }

        $asset->setContent($content);
    }

}