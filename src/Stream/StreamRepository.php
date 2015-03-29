<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class StreamRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
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
     * @param array $attributes
     * @return StreamInterface
     */
    public function create(array $attributes)
    {
        $attributes['order_by']     = array_get($attributes, 'order_by', 'id');
        $attributes['title_column'] = array_get($attributes, 'title_column', 'id');

        $attributes['locked']       = (array_get($attributes, 'locked', false));
        $attributes['trashable']    = (array_get($attributes, 'trashable', false));
        $attributes['translatable'] = (array_get($attributes, 'translatable', false));

        $attributes['prefix']       = array_get($attributes, 'prefix', array_get($attributes, 'namespace') . '_');
        $attributes['view_options'] = array_get($attributes, 'view_options', ['id', 'created_at']);

        return $this->model->create($attributes);
    }

    /**
     * Delete a Stream.
     *
     * @param StreamInterface $stream
     */
    public function delete(StreamInterface $stream)
    {
        $stream->delete();

        $this->model->where('slug', $stream->getSlug())->where('namespace', $stream->getNamespace())->delete();
    }

    /**
     * Find a stream by it's namespace and slug.
     *
     * @param  $slug
     * @param  $namespace
     * @return null|StreamInterface
     */
    public function findBySlugAndNamespace($slug, $namespace)
    {
        return $this->model->where('slug', $slug)->where('namespace', $namespace)->first();
    }
}
