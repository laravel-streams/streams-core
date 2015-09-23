<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentRepository;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Database\Schema\Builder;

/**
 * Class StreamRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream
 */
class StreamRepository extends EloquentRepository implements StreamRepositoryInterface
{

    /**
     * The stream model.
     *
     * @var
     */
    protected $model;

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new StreamRepository instance.
     *
     * @param StreamModel $model
     */
    public function __construct(StreamModel $model)
    {
        $this->model = $model;

        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Create a new Stream.
     *
     * @param array $attributes
     * @return StreamInterface
     */
    public function create(array $attributes = [])
    {
        $attributes['slug']         = str_slug(array_get($attributes, 'slug'), '_');
        $attributes['view_options'] = array_get($attributes, 'view_options', ['id', 'created_at']);
        $attributes['prefix']       = array_get($attributes, 'prefix', array_get($attributes, 'namespace') . '_');

        if (isset($attributes['name'])) {
            array_set(
                $attributes,
                config('app.fallback_locale') . '.name',
                array_pull($attributes, 'name')
            );
        }

        if (isset($attributes['description'])) {
            array_set(
                $attributes,
                config('app.fallback_locale') . '.description',
                array_pull($attributes, 'description')
            );
        }

        return $this->model->create($attributes);
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

    /**
     * Find all streams in a namespace.
     *
     * @param  $namespace
     * @return null|EloquentCollection
     */
    public function findAllByNamespace($namespace)
    {
        return $this->model->where('namespace', $namespace)->get();
    }

    /**
     * Destroy a namespace.
     *
     * @param $namespace
     */
    public function destroy($namespace)
    {
        foreach ($this->findAllByNamespace($namespace) as $stream) {
            $this->delete($stream);
        }
    }

    /**
     * Clean up abandoned streams.
     */
    public function cleanup()
    {
        /* @var StreamInterface $stream */
        foreach ($this->model->all() as $stream) {
            if (!$this->schema->hasTable($stream->getEntryTableName())) {
                $this->delete($stream);
            }
        }
    }
}
