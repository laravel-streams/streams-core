<?php namespace Anomaly\Streams\Platform\Asset\Filter;

use Anomaly\Streams\Platform\Asset\Command\LoadThemeVariables;
use Anomaly\Streams\Platform\Asset\AssetParser;
use Anomaly\Streams\Platform\Support\Collection;
use Assetic\Asset\AssetInterface;
use Assetic\Filter\Sass\SassFilter;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Leafo\ScssPhp\Compiler;

class RubySassFilter extends SassFilter
{
    use DispatchesJobs;

    /**
     * The asset parser utility.
     *
     * @var AssetParser
     */
    protected $parser;

    /**
     * Create a new LessFilter instance.
     *
     * @param AssetParser $parser
     */
    public function __construct(AssetParser $parser)
    {
        $this->parser = $parser;

        parent::__construct(env('SASS_PATH', '/usr/bin/sass'), null);
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
        $this->dispatch(new LoadThemeVariables($variables = new Collection()));

        $compiler = new Compiler();

        if ($dir = $asset->getSourceDirectory()) {
            $compiler->addImportPath($dir);
        }

        $compiler->setVariables($variables->all());

        $asset->setContent($this->parser->parse($compiler->compile($asset->getContent())));
    }
}
