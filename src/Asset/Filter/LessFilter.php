<?php

namespace Anomaly\Streams\Platform\Asset\Filter;

use Anomaly\Streams\Platform\Asset\AssetParser;
use Anomaly\Streams\Platform\Asset\Command\LoadThemeVariables;
use Anomaly\Streams\Platform\Support\Collection;
use Assetic\Asset\AssetInterface;
use Assetic\Filter\LessphpFilter;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class LessFilter.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Filter
 */
class LessFilter extends LessphpFilter
{
    use DispatchesJobs;

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
        //
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $compiler = new \lessc();

        $this->dispatch(new LoadThemeVariables($variables = new Collection(config('theme::theme', config('theme')))));

        $compiler->setVariables($variables->all());

        if ($dir = $asset->getSourceDirectory()) {
            $compiler->importDir = $dir;
        }

        foreach ($this->loadPaths as $loadPath) {
            $compiler->addImportDir($loadPath);
        }

        $asset->setContent($compiler->parse($this->parser->parse($asset->getContent())));
    }
}
