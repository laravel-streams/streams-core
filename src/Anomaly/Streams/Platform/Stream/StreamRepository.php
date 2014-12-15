<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class StreamRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamRepository implements StreamRepositoryInterface
{

    /**
     * The stream model.
     *
     * @var
     */
    protected $model;

    /**
     * Create a new StreamRepository instance.
     *
     * @param StreamModel $model
     */
    public function __construct(StreamModel $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new Stream.
     *
     * @param        $namespace
     * @param        $slug
     * @param        $name
     * @param null   $prefix
     * @param null   $description
     * @param array  $viewOptions
     * @param string $titleColumn
     * @param string $orderBy
     * @param bool   $locked
     * @param bool   $translatable
     * @return StreamInterface
     */
    public function create(
        $namespace,
        $slug,
        $name,
        $prefix = null,
        $description = null,
        array $viewOptions = [],
        $titleColumn = 'id',
        $orderBy = 'id',
        $locked = false,
        $translatable = false
    ) {
        $stream = $this->model->newInstance();

        $stream->slug         = $slug;
        $stream->name         = $name;
        $stream->prefix       = $prefix;
        $stream->order_by     = $orderBy;
        $stream->locked       = $locked;
        $stream->namespace    = $namespace;
        $stream->description  = $description;
        $stream->view_options = $viewOptions;
        $stream->title_column = $titleColumn;
        $stream->translatable = $translatable;

        $stream->save();

        return $stream;
    }

    /**
     * Delete a Stream.
     *
     * @param $namespace
     * @param $slug
     * @return StreamInterface
     */
    public function delete($namespace, $slug)
    {
        $stream = $this->findByNamespaceAndSlug($namespace, $slug);

        $stream->delete();

        return $stream;
    }

    /**
     * Find a stream by it's namespace and slug.
     *
     * @param $namespace
     * @param $slug
     * @return mixed
     */
    public function findByNamespaceAndSlug($namespace, $slug)
    {
        return $this->model->where('namespace', $namespace)->where('slug', $slug)->first();
    }

    /**
     * Get all streams with a given namespace.
     *
     * @param $namespace
     * @return mixed
     */
    public function getAllWithNamespace($namespace)
    {
        return $this->model->where('namespace', $namespace)->get();
    }
}
