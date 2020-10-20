<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Workflow;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Stream\Workflows\BuildStream;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Repository\Contract\RepositoryInterface;

/**
 * Class StreamManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamManager
{

    use HasMemory;
    use Macroable;
    use Prototype;
    use FiresCallbacks;

    public $workflows = [
        'build' => BuildStream::class,
    ];

    /**
     * The streams collection.
     *
     * @var Collection
     */
    protected $collection;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->collection = new Collection;
    }

    /**
     * Make a stream instance.
     *
     * @param string $stream
     * @return Stream
     */
    public function make($stream)
    {
        return App::make('streams.instances.' . $stream);
    }

    /**
     * Check if a given
     * stream exists.
     *
     * @param string $handle
     * @return bool
     */
    public function has($handle)
    {
        return App::has('streams.instances.' . $handle);
    }

    /**
     * Build a stream instance.
     *
     * @param $stream
     * @return Stream
     */
    public function build($stream)
    {
        $stream = Arr::undot($stream);

        $workflow = $this->workflow('build');

        $workflow->stream = $stream;

        $workflow->process([
            'workflow' => $workflow
        ]);

        $stream = $workflow->stream;

        $stream->fire('built', ['stream' => $stream]);

        return $stream;
    }

    /**
     * Load a stream instance.
     *
     * @param $file
     * @return Stream
     */
    public function load($file)
    {
        $stream = json_decode(file_get_contents($file), true);

        $handle = basename($file, '.json');

        Arr::set($stream, 'handle', Arr::get($stream, 'handle', $handle));

        return $this->register($stream);
    }

    /**
     * Register a stream instance.
     *
     * @param array $stream
     * @return Stream
     */
    public function register(array $stream)
    {
        $stream = $this->build($stream);

        App::instance('streams.instances.' . $stream->handle, $stream);

        $this->collection->put($stream->handle, $stream);

        return $stream;
    }

    /**
     * Return an entry criteria.
     * 
     * @return CriteriaInterface
     */
    public function entries($stream)
    {
        return $this
            ->make($stream)
            ->entries();
    }

    /**
     * Return an entry repository.
     * 
     * @return RepositoryInterface
     */
    public function repository($stream)
    {
        return $this
            ->make($stream)
            ->repository();
    }

    /**
     * Return the Streams collection.
     * 
     * @return Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * Return a workflow by nane.
     *
     * @param string $name
     *
     * @return \Streams\Core\Support\Workflow
     */
    protected function workflow($name): Workflow
    {
        $workflow = Arr::get($this->workflows, $name);

        if (!class_exists($workflow)) {
            throw new \Exception("Workflow [{$name}] does not exist.");
        }

        return (new $workflow)
            ->setPrototypeAttribute('name', $name)
            ->passThrough($this);
    }
}
