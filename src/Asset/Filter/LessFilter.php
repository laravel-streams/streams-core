<?php namespace Anomaly\Streams\Platform\Asset\Filter;

use Anomaly\Streams\Platform\Asset\AssetParser;
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
     * The asset parser utility.
     *
     * @var AssetParser
     */
    protected $parser;

    /**
     * Create a new ParseFilter instance.
     *
     * @param AssetParser $parser
     */
    public function __construct(AssetParser $parser)
    {
        $this->parser = $parser;
    }

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

        $asset->setContent($compiler->parse($this->parser->parse($asset->getContent())));
    }
}
