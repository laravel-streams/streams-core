<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Support\Traits\Prototype;
use Anomaly\Streams\Platform\Stream\Workflows\BuildStream;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

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
     * @return \Anomaly\Streams\Platform\Support\Workflow
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
