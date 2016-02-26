<?php namespace Anomaly\Streams\Platform\Asset\Filter;

use Anomaly\Streams\Platform\Asset\AssetParser;
use Assetic\Asset\AssetInterface;
use Assetic\Filter\Sass\ScssFilter;

/**
 * Class RubyScssFilter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Filter
 */
class RubyScssFilter extends ScssFilter
{

    /**
     * The asset parser utility.
     *
     * @var AssetParser
     */
    protected $parser;

    /**
     * Create a new RubyScssFilter instance.
     *
     * @param AssetParser $parser
     */
    public function __construct(AssetParser $parser)
    {
        $this->parser = $parser;

        parent::__construct('/usr/bin/sass', null);
    }

    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset
     */
    public function filterLoad(AssetInterface $asset)
    {
        $asset->setContent($this->parser->parse($asset->getContent()));

        parent::filterLoad($asset);
    }
}
