<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Contracts\Config\Repository;

/**
 * Class MergeStreamConfig
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MergeStreamConfig
{

    /**
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new MergeStreamConfig instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     *
     * @param AddonCollection $addons
     * @param Repository      $repository
     */
    public function handle(AddonCollection $addons, Repository $repository)
    {
        $slug      = $this->stream->getSlug();
        $namespace = $this->stream->getNamespace();

        foreach ($addons->withConfig("streams.{$namespace}.{$slug}") as $config) {
            $this->stream->mergeConfig($config);
        }

        $this->stream->mergeConfig($repository->get("streams::streams.{$namespace}.{$slug}", []));
    }
}
