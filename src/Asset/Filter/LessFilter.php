<?php namespace Anomaly\Streams\Platform\Asset\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\LessphpFilter;

/**
 * Class LessFilter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Filter
 */
class LessFilter extends LessphpFilter
{

    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset
     */
    public function filterLoad(AssetInterface $asset)
    {
        $compiler = new \lessc();

        $compiler->setVariables(config('theme::theme', config('theme')));

        if ($dir = $asset->getSourceDirectory()) {
            $compiler->importDir = $dir;
        }

        foreach ($this->loadPaths as $loadPath) {
            $compiler->addImportDir($loadPath);
        }

        $asset->setContent($compiler->parse($asset->getContent()));
    }
}
