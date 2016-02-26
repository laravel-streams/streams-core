<?php namespace Anomaly\Streams\Platform\Asset\Filter;

use Anomaly\Streams\Platform\Asset\AssetParser;
use Assetic\Asset\AssetInterface;

/**
 * Class NodeLessFilter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Filter
 */
class NodeLessFilter extends \Assetic\Filter\LessFilter
{

    /**
     * The asset parser utility.
     *
     * @var AssetParser
     */
    protected $parser;

    /**
     * Create a new NodeLessFilter instance.
     *
     * @param AssetParser $parser
     */
    public function __construct(AssetParser $parser)
    {
        $this->parser = $parser;

        parent::__construct(
            '/usr/local/bin/node',
            [
                '/usr/local/lib/node_modules',
                '/usr/local/lib/node_modules/less/bin/lessc'
            ]
        );
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
