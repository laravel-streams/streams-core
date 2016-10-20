<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Contracts\Container\Container;

/**
 * Class GetStream
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetStream
{

    /**
     * The stream slug.
     *
     * @var string
     */
    protected $slug;

    /**
     * The stream namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Create a new GetStream instance.
     *
     * @param string $namespace
     * @param string $slug
     */
    public function __construct($namespace, $slug)
    {
        $this->slug      = $slug;
        $this->namespace = $namespace;
    }

    /**
     * Handle the command.
     *
     * @param  Container                                                      $container
     * @return \Anomaly\Streams\Platform\Stream\Contract\StreamInterface|null
     */
    public function handle(Container $container)
    {
        /* @var EntryInterface $model */
        $model = $container->make(
            "Anomaly\\Streams\\Platform\\Model\\{$this->namespace}\\{$this->namespace}{$this->slug}EntryModel"
        );

        return $model->getStream();
    }
}
